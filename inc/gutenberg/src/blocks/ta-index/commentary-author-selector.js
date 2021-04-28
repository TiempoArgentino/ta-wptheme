/**
*   Replaces the terms selector for the ta_article_author taxonomy in gutenberg editor
*/
import {hookComponentToNode} from './admin-components';
import RBTermsSelector from '../../components/RBTermsSelector/RBTermsSelector';
import React, { useState, useEffect } from "react";
const {apiFetch} = wp;
const { addQueryArgs } = wp.url;
const { useSelect, useDispatch } = wp.data;
const { Spinner } = wp.components;
const $ = require('jquery');

const CommentReplyAuthorSelector = (props = {}) => {
    const { node, onUpdate: updateCallback } = props;
    const [termID, setTermID] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect( () => {
        if(commentReply.act != 'edit-comment' || !commentReply.cid){
            setLoading(false);
            return;
        }

        apiFetch( { path: `/wp/v2/comments/${commentReply.cid}` } )
            .then( ( comment ) => {
                console.log('COMMENT', comment);
                if(comment && comment.meta && comment.meta.ta_comment_author)
                    setTermID(comment.meta.ta_comment_author);
                setLoading(false);
            });
    }, []);

    const onUpdate = (data) => {
        const {termsData, dataBeingFetched} = data;
        if(dataBeingFetched)
            return;
        let newTermID = null;
        if(termsData && termsData.length && termsData[0].data){
            newTermID = termsData[0].data.id;
            console.log(newTermID);
        }
        // console.log('SET TERM ID', newTermID);
        setTermID(newTermID);
        if(updateCallback)
            updateCallback({termID: newTermID});
    };

    return (
        <>
            { loading &&
                <p><Spinner/> Cargando</p>
            }
            { !loading &&
                <>
                    <RBTermsSelector
                        taxonomy = "ta_article_author"
                        terms = {termID ? [termID] : []}
                        termsQueryField = "include"
                        onUpdate = {onUpdate}
                        max = {1}
                        sortable = {false}
                    />
                </>
            }
        </>
    );
}



hookComponentToNode({
    component: ({ node, nodeBeforeMount }) => {
        const onUpdate = ({termID}) => {
            $(node).find('input[name="ta_comment_author"]').focus().val(termID).trigger('change');
        };

        return <CommentReplyAuthorSelector node = {nodeBeforeMount} onUpdate = { onUpdate }/>
    },
    querySelector: `#replyrow:not([style*="display:none;"]) .photographer-field`,
    removeOldHtml: false,
});

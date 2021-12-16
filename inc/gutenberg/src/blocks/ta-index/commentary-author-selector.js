/**
*   Replaces the terms selector for the ta_article_author taxonomy in gutenberg editor
*/
import {hookComponentToNode} from './admin-components';
import RBTermsSelector from '../../components/RBTermsSelector/RBTermsSelector';
import React, { useState, useEffect } from "react";
import { fetchAuthors } from '../../helpers/useTAAuthors/useTAAuthors';
const {apiFetch} = wp;
const { addQueryArgs } = wp.url;
const { useSelect, useDispatch } = wp.data;
const { Spinner, RadioControl } = wp.components;
const $ = require('jquery');

const CommentReplyAuthorSelector = (props = {}) => {
    const { node, onUpdate: updateCallback, commentPostID } = props;
    const [commentAuthorID, setCommentAuthorID] = useState(null);
    const [postAuthors, setPostAuthors] = useState(null);
    const [loadingCommentAuthorMetaValue, setLoadingCommentAuthorMetaValue] = useState(true);
    const [loadingAuthors, setLoadingAuthors] = useState(true);
    // indicates if the comment can have an author selected.
    const [isValidComment, setIsValidComment] = useState(true);
    const isLoading = loadingCommentAuthorMetaValue || loadingAuthors;

    useEffect( () => {
        if((commentReply.act != 'edit-comment' && commentReply.act != 'replyto-comment' ) || !commentReply.cid){
            setLoadingCommentAuthorMetaValue(false);
            return;
        }

        apiFetch( { path: `/wp/v2/comments/${commentReply.cid}` } )
            .then( ( comment ) => {
                console.log('COMMENT', comment);
                const isReplyOrEditingReply = commentReply.act == 'replyto-comment' || comment.parent != 0;
                if( isReplyOrEditingReply ){
                    setIsValidComment(true);
                    if(comment && comment.meta && comment.meta.ta_comment_author){
                        onAuthorChange(comment.meta.ta_comment_author);
                    }
                }
                else{
                    setIsValidComment(false);
                }
                setLoadingCommentAuthorMetaValue(false);
            });

        if(commentPostID){
            fetchAuthors({
                args: {
                    object_ids: commentPostID,
                },
            })
            .then((data) => {
                console.log('AUTHORS', data);
                setPostAuthors(data);
                setLoadingAuthors(false);
            });
        }
        else{
            setLoadingAuthors(false);
        }

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
        onAuthorChange(newTermID);
        setCommentAuthorID(newTermID);
    };

    const onAuthorChange = (authorID) => {
        const newID = parseInt(authorID);
        setCommentAuthorID(newID);
        if(updateCallback)
            updateCallback({commentAuthorID: newID});
    };

    const getAuthors = () => {
        if(postAuthors && postAuthors.length){
            const options = postAuthors.map( ({ ID, name }) => {
                return { label: name, value: ID };
            });

            return (
                <RadioControl
                    label="Responder como"
                    help=""
                    selected={ parseInt(commentAuthorID ? commentAuthorID : 0) }
                    options={ [{ label: 'Autor del comentario (usuario Wordpress)', value: 0 }, ...options] }
                    onChange={ onAuthorChange }
                />
            );
        }
        return null;
    }

    if(!isValidComment)
        return null;

    return (
        <>
            { isLoading &&
                <p><Spinner/> Cargando</p>
            }
            { !isLoading &&
                <>
                    {getAuthors()}
                    { false &&
                        // OLD SELECTOR - allows to select any author on the site
                        <RBTermsSelector
                            taxonomy = "ta_article_author"
                            terms = {commentAuthorID ? [commentAuthorID] : []}
                            termsQueryField = "include"
                            onUpdate = {onUpdate}
                            max = {1}
                            sortable = {false}
                        />
                    }

                </>
            }
        </>
    );
}



hookComponentToNode({
    component: ({ node, nodeBeforeMount }) => {
        const onUpdate = ({commentAuthorID}) => {
            $(node).find('input[name="ta_comment_author"]').focus().val(commentAuthorID).trigger('change');
        };

        const commentPostID = $('input[name="comment_post_ID"]').val();
        console.log('commentPostID', commentPostID);
        return <CommentReplyAuthorSelector node = {nodeBeforeMount} onUpdate = { onUpdate } commentPostID = {commentPostID}/>
    },
    querySelector: `#replyrow:not([style*="display:none;"]) .photographer-field`,
    removeOldHtml: false,
});

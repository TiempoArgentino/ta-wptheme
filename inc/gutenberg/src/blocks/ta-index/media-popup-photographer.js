import {hookComponentToNode} from './admin-components';
import { render, unmountComponentAtNode } from "react-dom";
import RBTermsSelector from '../../components/RBTermsSelector/RBTermsSelector';
const { useSelect } = wp.data;
import React, { useState, useEffect } from "react";
const $ = require('jquery');

const MediaPopupPhotographerSelector = (props) => {
    const { node, onUpdate: updateCallback } = props;
    const [termSlugs, setTermSlugs] = useState([]);
    const [prepared, setPrepared] = useState(false);
    const [attachmentID, setAttachmentID] = useState(null);
    const value = termSlugs.join(',');

    useEffect( () => {
        const labelFor = node.querySelector('input.text').attributes.id.value;
        const inputValue = node.querySelector('input.text').value;
        const value = inputValue && inputValue.trim() ? inputValue.split(',') : [];
        const firstDashIdx = labelFor.indexOf("-");
        const secondDashIndx = labelFor.indexOf("-", firstDashIdx + 1);
        const attachmentID = labelFor.substring(firstDashIdx + 1, secondDashIndx);
        setAttachmentID(attachmentID);
        setTermSlugs(value);
        setPrepared(true);
    }, [node]);

    const onUpdate = (data) => {
        const {termsData, dataBeingFetched} = data
        if(dataBeingFetched)
            return;
        if(!!termsData || !termsData.length)
            setTermSlugs([]);
        const slugs = termsData.map( termData => termData.data.slug );
        setTermSlugs(slugs);
        if(updateCallback)
            updateCallback({slugs});
    };

    // const terms = useSelect( ( select, props ) => {
    //     const { getEntityRecords } = select( 'core' );
    //     console.log(attachmentID);
    //     const terms = getEntityRecords( 'taxonomy', 'ta_photographer', {
    //         slug: value,
    //         post: attachmentID,
    //     });
    //     console.log(terms);
    //     return terms;
    // } );

    return (
        <>
            { !prepared &&
                <p>Cargando</p>
            }
            { prepared &&
                <>
                    <RBTermsSelector
                        taxonomy = "ta_photographer"
                        terms = {termSlugs}
                        termsQueryField = "slug"
                        onUpdate = {onUpdate}
                        max = {1}
                        sortable = {false}
                    />
                </>
            }
        </>
    );
};

hookComponentToNode({
    component: ({ node, nodeBeforeMount }) => {
        const onUpdate = ({slugs}) => {
            $(node).find('input.text').focus().val(slugs.join(',')).trigger('change');
            // console.log($(node).find('input.text'));
        };

        return <MediaPopupPhotographerSelector node = {nodeBeforeMount} onUpdate = { onUpdate } />
    },
    querySelector: `.media-sidebar .compat-field-ta_photographer .field`,
    removeOldHtml: false,
});

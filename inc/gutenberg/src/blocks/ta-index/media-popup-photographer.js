import {hookComponentToNode} from './admin-components';
import { render, unmountComponentAtNode } from "react-dom";
import TAPhotographerSelector from '../../components/TAPhotographerSelector/TAPhotographerSelector';
const { useSelect } = wp.data;
import React, { useState, useEffect, useRef } from "react";
const $ = require('jquery');

const MediaPopupPhotographerSelector = (props) => {
    const { node, onUpdate: updateCallback } = props;
    const [termSlugs, setTermSlugs] = useState([]);
    const [prepared, setPrepared] = useState(false);
    const [attachmentID, setAttachmentID] = useState(null);
    const inputRef = useRef(null);
    const value = termSlugs.join(',');
    console.log(value);

    useEffect( () => {
        const labelFor = node.querySelector('input.text').attributes.id.value;
        const value = node.querySelector('input.text').value.split(',');
        const firstDashIdx = labelFor.indexOf("-");
        const secondDashIndx = labelFor.indexOf("-", firstDashIdx + 1);
        const attachmentID = labelFor.substring(firstDashIdx + 1, secondDashIndx);
        setAttachmentID(attachmentID);
        setTermSlugs(value);
        setPrepared(true);
    }, [node]);

    const onUpdate = ({termsData}) => {
        if(!termsData || !termsData.length)
            setTermSlugs([]);
        const slugs = termsData.map( termData => termData.term.slug );
        setTermSlugs(slugs);
        if(updateCallback)
            updateCallback({slugs});
        // $(inputRef.current).val(value)
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

    const inputID = `attachments-${attachmentID}-ta_photographer`;
    const inputName = `attachments[${attachmentID}][ta_photographer]`;

    return (
        <>
            { !prepared &&
                <p>Cargando</p>
            }
            { prepared &&
                <>
                    <TAPhotographerSelector
                        terms = { termSlugs }
                        termsQueryField = "slug"
                        onUpdate = { onUpdate }
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

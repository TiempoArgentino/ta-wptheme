import React, { useState, useEffect } from "react";
const { MediaUpload, MediaUploadCheck } = wp.editor;
const { __ } = wp.i18n;
const { useSelect } = wp.data;
const { Button, Spinner, ResponsiveWrapper } = wp.components;

/**
*   @param {int[]} attachmentsIDs                                               Array of attachments ids. If its not a gallery, only the first index is used
*   @param {bool} gallery
*   @param {string[]} allowedMediaTypes                                         Array of allowed media types
*   @param {callback} onChange                                                  Function to excecute when the attachments change. Recieves an object with `attachments` key.
*   @param {object} labels                                                      Object that defined the labels to use in the component
*/
const RBAttachmentControl = (props) => {
    const {
        attachmentsIDs = [],
        gallery = false,
        allowedMediaTypes = [ 'image' ],
        onChange,
        labels,
    } = props;

    const {
        title: titleLabel = 'Select Image',
        imageAlt: imageAltLabel = 'Selected Image',
        setImage: setImageLabel = 'Set Image',
        remove: removeLabel = 'Remove',
        modifyGallery: modifyGalleryLabel = 'Modify Gallery',
    } = labels;

    const instructions = <p>{ __( 'To edit the background image, you need permission to upload media.', 'ta-theme' ) }</p>;
    const attachments = useSelect( ( select, props ) => {
        const { getMedia } = select( 'core' );
        const result = [];
        if(attachmentsIDs){
            attachmentsIDs.forEach((attachmentID, i) => {
                const media = attachmentID ? getMedia( attachmentID ) : null;
                if(media)
                    result.push(media);
            });
        }
        return result;
    } );
    const haveAttachments = attachmentsIDs.length > 0;
    const attachmentsDataLoaded = (attachments && attachments.length > 0) || attachmentsIDs.length == 0;
    const mediaComponentValue = gallery ? attachmentsIDs : attachmentsIDs[0];

    const doOnChange = (attachments) => {
        if(onChange)
            onChange({
                attachments: gallery ? attachments : [attachments],
            });
    }

    return (
        <>
            <MediaUploadCheck fallback={ instructions }>
                <MediaUpload
                    title={ titleLabel }
                    onSelect={ doOnChange }
                    allowedTypes={ allowedMediaTypes }
                    value={ mediaComponentValue }
                    multiple = { gallery }
                    gallery = { gallery }
                    render={ ( { open } ) => (
                        <Button
                            className={ !haveAttachments ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview' }
                            onClick={ open }>
                            { !haveAttachments && attachmentsDataLoaded && ( setImageLabel ) }
                            { !attachmentsDataLoaded && <Spinner /> }
                            { haveAttachments && attachmentsDataLoaded &&
                                <div>
                                    { gallery && (modifyGalleryLabel) }
                                    { !gallery &&
                                    <img src={ attachments[0].source_url } alt={ imageAltLabel } />
                                    }
                                </div>
                            }
                        </Button>
                    ) }
                />
            </MediaUploadCheck>
            { !! attachmentsIDs &&
            <MediaUploadCheck>
                <Button onClick={ () => doOnChange(null) } isLink isDestructive>
                    { removeLabel }
                </Button>
            </MediaUploadCheck>
            }
        </>
    )
};

export default RBAttachmentControl;

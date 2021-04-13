/**
*   Adds a panel with a control to manage the article alternative image (cover)
*/
import React, { useState } from "react";
import RBAttachmentControl from '../../components/RBAttachmentControl/RBAttachmentControl';
const { registerPlugin } = wp.plugins;
const { PluginDocumentSettingPanel } = wp.editPost;
const { __ } = wp.i18n;
const { useEntityProp } = wp.coreData;

const TAArticleAltThumbnailPanel = () => {
    const postType = wp.data.select( 'core/editor' ).getCurrentPostType();
    if(postType !== 'ta_article')
        return null;

    const [ meta, setMeta ] = useEntityProp(
        'postType',
        postType,
        'meta'
    );
    const metaImageId = meta && meta['ta_article_thumbnail_alt'] ? meta['ta_article_thumbnail_alt'] : null;
    function updateMetaValue( {attachments} ) {
        const attachment = attachments ? attachments[0] : null;
        setMeta( { ...meta, 'ta_article_thumbnail_alt': attachment ? attachment.id : null } );
    }

    return (
        <PluginDocumentSettingPanel
            name="ta-alt-img"
            title="Imagen Portada"
            className="custom-panel"
        >
            <RBAttachmentControl
                attachmentsIDs = {metaImageId ? [metaImageId] : []}
                allowedMediaTypes = {[ 'image' ]}
                onChange = { updateMetaValue }
                labels = {{
                    title: 'Imagen Portada',
                    imageAlt: 'Imagen Portada',
                    setImage: 'Establecer Imagen Portada',
                    remove: 'Quitar',
                }}
            />
        </PluginDocumentSettingPanel>
    );
};

registerPlugin( 'ta-article-alt-thumbnail-panel', {
    render: TAArticleAltThumbnailPanel,
    icon: 'format-image',
} );

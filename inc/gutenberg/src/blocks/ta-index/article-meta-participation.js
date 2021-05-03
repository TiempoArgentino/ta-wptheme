/**
*   Adds a panel with a control to manage the sister article
*/
import React, { useEffect } from "react";
import RBPostsSelector from '../../components/rb-posts-selector/rb-posts-selector';
import {LRArticlesSelector} from '../../components/lr-articles-selector/lr-articles-selector';
import { useRBPosts } from '../../helpers/posts/posts';
import { isArticlePostType } from '../../helpers/ta-article/lr-articles';
const { registerPlugin } = wp.plugins;
const { PluginDocumentSettingPanel } = wp.editPost;
const { __ } = wp.i18n;
const { useEntityProp } = wp.coreData;
const { useSelect, useDispatch } = wp.data;
const { Spinner, CheckboxControl, DateTimePicker, TextControl } = wp.components;

// REMOVE DEFAULT COMMENTS STATUS BOX
const participationPanelUnsubscribe = wp.data.subscribe(() => {
    const postType =  wp.data.select('core/editor').getCurrentPostType();

    if( postType == undefined )
        return;

    const { removeEditorPanel } = wp.data.dispatch('core/edit-post');
    participationPanelUnsubscribe();

    if(isArticlePostType(postType))
        removeEditorPanel( 'discussion-panel' );
});


const TAParticipationMeta = () => {
    const postType = useSelect( (select) => {
        return select('core/editor').getCurrentPostType();
    });
    if(!isArticlePostType(postType))
        return null;

    const [ meta, setMeta ] = useEntityProp(
        'postType',
        postType,
        'meta'
    );

    const commentStatus = useSelect( (select) => {
        return select('core/editor').getEditedPostAttribute('comment_status');
    });
    const haveCommentOpen = commentStatus == 'open' ? true : false;
    const {editPost} = useDispatch( 'core/editor' );
    const metaValue = meta && meta['ta_article_participation'] ? meta['ta_article_participation'] : {};
    const {
        use,
        live_date,
        live_title,
        live_link,
        use_live_date,
    } = metaValue;

    function updateMetaValue( { key, value } ) {
        setMeta( { ...meta, 'ta_article_participation': {
            ...metaValue,
            [key]: value,
        } } );
    }

    return (
        <PluginDocumentSettingPanel
            name="ta-participation"
            title="Comentarios / Participación"
            className="custom-panel"
        >
            <CheckboxControl
                label="Permitir comentarios"
                checked={ haveCommentOpen }
                onChange={ ( value ) => editPost( { comment_status: value ? 'open' : 'closed' } ) }
            />
            { haveCommentOpen &&
            <>
                <CheckboxControl
                    label="Usar Preguntá y Participá"
                    checked={ use }
                    onChange={ ( value ) => updateMetaValue( { key: 'use', value } ) }
                />
                { use &&
                <>
                    <TextControl
                        label="Título de la transmisión"
                        value={ live_title }
                        onChange={ ( value ) => updateMetaValue( { key: 'live_title', value } ) }
                    />
                    <TextControl
                        label="Link a la transmisión"
                        value={ live_link }
                        onChange={ ( value ) => updateMetaValue( { key: 'live_link', value } ) }
                    />
                    <CheckboxControl
                        label="Permitir establecer horario de la transmisión"
                        checked={ use_live_date }
                        onChange={ ( value ) => updateMetaValue( { key: 'use_live_date', value } ) }
                    />
                    {use_live_date &&
                    <>
                        <h2>Fecha y hora de la transmisión</h2>
                        <DateTimePicker
                            currentDate={ live_date ? new Date(live_date) : null }
                            onChange={ ( date ) => updateMetaValue( { key: 'live_date', value: new Date(date).getTime() } ) }
                            is12Hour={ true }
                        />
                    </>
                    }
                </>
                }
            </>
            }
        </PluginDocumentSettingPanel>
    );
};

registerPlugin( 'ta-participation', {
    render: TAParticipationMeta,
    icon: 'admin-comments',
} );

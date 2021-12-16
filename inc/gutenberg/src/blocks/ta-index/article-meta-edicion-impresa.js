/**
*   Adds a panel with a control to manage the related paper post
*/
import React, { useEffect } from "react";
import RBPostsSelector from '../../components/rb-posts-selector/rb-posts-selector';
import { useRBPosts } from '../../helpers/posts/posts';
const { registerPlugin } = wp.plugins;
const { PluginDocumentSettingPanel } = wp.editPost;
const { __ } = wp.i18n;
const { useEntityProp } = wp.coreData;
const { Spinner } = wp.components;

const TAEdicionImpresaPanel = () => {
    const postType = wp.data.select( 'core/editor' ).getCurrentPostType();
    if(postType !== 'ta_article')
        return null;

    const [ meta, setMeta ] = useEntityProp(
        'postType',
        postType,
        'meta'
    );

    const metaValue = meta && meta['ta_article_edicion_impresa'] ? meta['ta_article_edicion_impresa'] : null;
    function updateMetaValue( posts ) {
        const postData = posts ? posts[0] : null;
        const postID = postData ? postData.ID : null;
        setPostsData(postData ? [{ data: postData, loading: false, originalValue: postID }] : []);
        setMeta( { ...meta, 'ta_article_edicion_impresa': postID } );
    }

    const {
        postsData,
        setPostsData,
    } = useRBPosts({
        posts: metaValue ? [metaValue] : [],
        postsQueryArgs: {
            post_type: 'ta_ed_impresa',
        },
        // onChange: (data) => {
        //     console.log('ON CHANGE', data);
        // },
    });

    const postFetched = postsData && postsData.length ? postsData[0] : null;
    const postData = postFetched ? postFetched.data : null;
    const loading = postFetched ? postFetched.loading : false;

    return (
        <PluginDocumentSettingPanel
            name="ta-ed-impresa"
            title="Edición Impresa"
            className="custom-panel"
        >
            <RBPostsSelector
                posts = { postData ? [postData] : [] }
                postsArgs = {{
                    post_type: 'ta_ed_impresa',
                    post_status: ['publish', 'future'],
                }}
                max = {1}
                onSelectionChange = { (data) => updateMetaValue(data) }
                sortable = {false}
            />
            { loading && <Spinner/> }
        </PluginDocumentSettingPanel>
    );
};

registerPlugin( 'ta-ed-impresa', {
    render: TAEdicionImpresaPanel,
    icon: 'media-document',
} );

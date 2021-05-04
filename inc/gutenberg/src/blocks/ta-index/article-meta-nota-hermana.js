/**
*   Adds a panel with a control to manage the sister article
*/
import React, { useEffect } from "react";
import RBPostsSelector from '../../components/rb-posts-selector/rb-posts-selector';
import {LRArticlesSelector} from '../../components/lr-articles-selector/lr-articles-selector';
import { useRBPosts } from '../../helpers/posts/posts';
import { useTAArticles } from '../../helpers/ta-article/useTAArticles';
const { registerPlugin } = wp.plugins;
const { PluginDocumentSettingPanel } = wp.editPost;
const { __ } = wp.i18n;
const { useEntityProp } = wp.coreData;
const { Spinner } = wp.components;

const TANotaHermanaPanel = () => {
    const postType = wp.data.select( 'core/editor' ).getCurrentPostType();
    if(postType !== 'ta_article')
        return null;

    const [ meta, setMeta ] = useEntityProp(
        'postType',
        postType,
        'meta'
    );

    const metaValue = meta && meta['ta_article_sister_article'] ? meta['ta_article_sister_article'] : null;
    function updateMetaValue( posts ) {
        const postData = posts ? posts[0] : null;
        const postID = postData ? postData.ID : null;
        setArticlesData(postData ? [{ data: postData, loading: false, originalValue: postID }] : []);
        setMeta( { ...meta, 'ta_article_sister_article': postID } );
    }

    const {
        articlesData,
        setArticlesData,
    } = useTAArticles( {
        posts: metaValue ? [metaValue] : [],
        postsQueryArgs: {
            post_type: 'ta_article',
        },
    } );

    const postFetched = articlesData && articlesData.length ? articlesData[0] : null;
    const postData = postFetched ? postFetched.data : null;
    const loading = postFetched ? postFetched.loading : false;

    return (
        <PluginDocumentSettingPanel
            name="ta-nota-hermana"
            title="Nota Hermana"
            className="custom-panel"
        >
            <LRArticlesSelector
                articles = { postData ? [postData] : [] }
                postsArgs = {{
                    post_type: 'ta_article',
                }}
                max = {1}
                onSelectionChange = { (data) => updateMetaValue(data) }
                sortable = {false}
            />
            { loading && <Spinner/> }
        </PluginDocumentSettingPanel>
    );
};

registerPlugin( 'ta-article-nota-hermana', {
    render: TANotaHermanaPanel,
    icon: 'media-document',
} );


/*

import React, { useEffect } from "react";
import RBPostsSelector from '../../components/rb-posts-selector/rb-posts-selector';
import { useRBPosts } from '../../helpers/posts/posts';
const { registerPlugin } = wp.plugins;
const { PluginDocumentSettingPanel } = wp.editPost;
const { __ } = wp.i18n;
const { useEntityProp } = wp.coreData;
const { Spinner } = wp.components;

const TANotaHermanaPanel = () => {
    const postType = wp.data.select( 'core/editor' ).getCurrentPostType();
    if(postType !== 'ta_article')
        return null;

    const [ meta, setMeta ] = useEntityProp(
        'postType',
        postType,
        'meta'
    );
    // useEffect( () => {
    //     console.log('CAMBIO', meta['ta_article_sister_article']);
    // },  meta['ta_article_sister_article']);
    const metaValue = meta && meta['ta_article_sister_article'] ? meta['ta_article_sister_article'] : null;
    function updateMetaValue( posts ) {
        const postData = posts ? posts[0] : null;
        const postID = postData ? postData.ID : null;
        setPostsData(postData ? [{ data: postData, loading: false, originalValue: postID }] : []);
        setMeta( { ...meta, 'ta_article_sister_article': postID } );
    }

    const {
        postsData,
        setPostsData,
    } = useRBPosts({
        posts: metaValue ? [metaValue] : [],
        postsQueryArgs: {
            post_type: 'ta_article',
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
            name="ta-nota-hermana"
            title="Nota Hermana"
            className="custom-panel"
        >
            <RBPostsSelector
                posts = { postData ? [postData] : [] }
                postsArgs = {{
                    post_type: 'ta_article',
                }}
                max = {1}
                onSelectionChange = { (data) => updateMetaValue(data) }
                sortable = {false}
            />
            { loading && <Spinner/> }
        </PluginDocumentSettingPanel>
    );
};

registerPlugin( 'ta-article-nota-hermana', {
    render: TANotaHermanaPanel,
    // icon: 'format-image',
} );
*/

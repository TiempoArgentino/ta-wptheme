/** @jsx createElement */
/*** @jsxFrag createFragment */
import { createElement, createFragment } from '../jsx/jsx';
import { apiArticleToBalancerData } from './scheme';
import { htmlDecode } from './helpers';

export function getArticlePreviewAttr({
    articleData = {},
    className = '',
    useBalancerIcons = false,
}){
    let attrs = {
        class: `article-preview ${className}`,
        "data-id": articleData?.postId ?? '',
    };

    if(useBalancerIcons){
        attrs["data-icons"] = true;
        attrs["data-balancer"] = JSON.stringify(apiArticleToBalancerData({articleData}));
    }

    return attrs;
};

export function getAuthorsLinks({ authors }){
    if(authors?.length <= 0)
        return null;
    return authors.map( (author, i) => {
        const separator = authors[i + 1] ? (i + 2 == authors.length ? " y " : ", ") : null;
        return (
            <>
                <a href={author?.authorUrl ?? ''}>{htmlDecode(author?.authorName) ?? ''}</a>
                { separator !== null ? <span>{separator}</span> : '' }
            </>
        )
    } );
}

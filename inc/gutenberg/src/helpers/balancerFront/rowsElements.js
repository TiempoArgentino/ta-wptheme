/** @jsx createElement */
/*** @jsxFrag createFragment */
import { createElement, createFragment } from '../jsx/jsx';
import ArticlePreviewCommon from './elements/ArticlePreviewCommon';
import ArticlePreviewOpinion from './elements/ArticlePreviewOpinion';

export function renderArticlePreview({
    articleData,
    size,
    className = '',
    deactivateOpinionLayout = false,
    desktopHorizontal = false,
}){
    let Render = ArticlePreviewCommon;
    if(!deactivateOpinionLayout && articleData?.isOpinion && articleData?.authors?.length > 0)
        Render = ArticlePreviewOpinion;

    return (
        <Render
            desktopHorizontal = {desktopHorizontal}
            className = {className}
            articleData = {articleData}
        />
    )
}

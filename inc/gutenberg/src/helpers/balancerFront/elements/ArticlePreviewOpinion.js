/** @jsx createElement */
/*** @jsxFrag createFragment */
import { createElement, createFragment } from '../../jsx/jsx';
import { getArticlePreviewAttr, getAuthorsLinks } from '../previewsElements';

export default function ArticlePreviewOpinion(props = {}){
    const {
        desktopHorizontal = false,
        className = '',
        articleData = {},
    } = props;

    const author = articleData?.authors?.length ? articleData.authors[0] : null;

    if(!author)
        return null;

    const thumb_cont_class = desktopHorizontal ? 'col-5 col-md-6 p-0' : 'col-4 col-md-12 p-0';
    const info_class = desktopHorizontal ? 'col-7 col-md-6' : 'col-8 col-md-12 text-md-center';
    const title_class = desktopHorizontal ? '' : 'w-75 mx-md-auto';
    let preview_class = desktopHorizontal ? 'd-flex py-3' : 'py-2 d-flex flex-row flex-md-column';

    const articlePreviewAttrs = getArticlePreviewAttr({
        articleData,
        className: `autor light-blue-bg context-bg mb-3`,
        useBalancerIcons: true,
    });

    return (
        <div {...articlePreviewAttrs}>
            <div class={preview_class}>
                <div class={thumb_cont_class}>
                    <a href={articleData?.url ?? ''}>
                        <div class="img-container position-relative">
                            <div class="img-wrapper" style={ `background-image: url("${author.authorImg}");` } alt={ author?.authorName ?? '' }></div>
                        </div>
                    </a>
                </div>
                <div class={`content ${info_class}`}>
                    <div class="title">
                        <a href={articleData?.url ?? ''}>
                            <p class={`nota-title ${title_class}`}>“{articleData?.title ?? ''}”</p>
                        </a>
                    </div>
                    <div class="article-info-container d-block">
                        <div class="author">
                            <p>Por {getAuthorsLinks({ authors: [author] })}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

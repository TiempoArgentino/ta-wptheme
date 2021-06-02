/** @jsx createElement */
/*** @jsxFrag createFragment */
import { createElement, createFragment } from '../../jsx/jsx';
import { getArticlePreviewAttr, getAuthorsLinks } from '../previewsElements';

export default function ArticlePreviewCommon(props = {}){
    const {
        desktopHorizontal = false,
        className = '',
        articleData = {},
    } = props;
    const html = '';
    const thumb_cont_class = desktopHorizontal ? 'col-5 col-md-6 pr-0 pl-0' : '';
    const info_class = desktopHorizontal ? 'col-7 col-md-6' : '';
    let preview_class = desktopHorizontal ? 'd-flex' : '';
    preview_class += ` ${className}`;
    const articlePreviewAttrs = getArticlePreviewAttr({
        articleData,
        className: `mb-3 ${preview_class}`,
        useBalancerIcons: true,
    });

    return (
        <div {...articlePreviewAttrs}>
            { articleData?.imgURL &&
            <div class={thumb_cont_class}>
                <a data-url href={articleData?.url ?? ''}>
                    <div class="img-container">
                        <div class="img-wrapper d-flex align-items-end" data-thumbnail style={ `background-image: url("${articleData.imgURL}");` } alt={articleData?.imgAlt ?? ''}>
                            <div class="icons-container">
                                <div class="article-icons d-flex flex-column position-absolute">
                                    <img data-icon="location" src={`${TABalancerApiData?.themeUrl}/assets/img/icon-img-1.svg`} alt="" />
                                    <img data-icon="favorite" src={`${TABalancerApiData?.themeUrl}/assets/img/icon-img-2.svg`} alt="" />
                                    <img data-icon="author" src={`${TABalancerApiData?.themeUrl}/assets/img/icon-img-3.svg`} alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            }

            <div class={`content ${info_class}`}>
                { articleData?.headband &&
                <>
                    <div class="article-border"></div>
                    <div class="category-title">
                        <h4 data-headband>{articleData.headband}</h4>
                    </div>
                </>
                }

                <div class="title">
                    <a data-url href={articleData?.url ?? ''}>
                        <p data-title>{articleData?.title ?? ''}</p>
                    </a>
                </div>
                { (articleData?.authors?.length > 0) &&
                <div class="article-info-container">
                    <div class="author">
                        <p>Por {getAuthorsLinks({ authors: articleData.authors })}</p>
                    </div>
                </div>
                }
            </div>
        </div>
    );
}

/** @jsx createElement */
/*** @jsxFrag createFragment */
import { createElement, createFragment } from '../../jsx/jsx';
import { getAuthorsLinks } from '../previewsElements';
let slidersGenerated = 0;

export default function ArticlesSliderRow(props = {}){
    let {
        articles = [],
    } = props;

    if( articles?.length <= 0 )
        return null;

    const $slides_amount = articles.length;
    let $is_first = true;
    let $printed_slides = 0;
    slidersGenerated++;
    const $slider_id = `ta_slider__${slidersGenerated}`;

    const slides = articles.map( ($article, $i) => {
        const $item_class = $printed_slides == 0 ? 'active' : '';
        $printed_slides++;
        return (
            <div class={`carousel-item ${$item_class}`}>
                <a href={$article?.url ?? ''}>
                    <div class="img-container">
                        <img class="d-block w-100" src={$article?.imgURL ?? ''}/>
                        <div class="overlay"></div>
                    </div>
                </a>
                <div class="carousel-caption text-left pt-0 mb-md-4">
                    <div class="separator"></div>
                    { $article?.headband &&
                    <div class="category-title mt-2">
                        <h4>{ $article.headband }</h4>
                    </div>
                    }
                    <div class="title">
                        <a href={$article?.url ?? ''}>
                            <p>{$article?.title ?? ''}</p>
                        </a>
                    </div>
                    <div class="article-info-container">
                        <div>
                            { $article?.authors?.length > 0 &&
                            <div class="author">
                                <p>Por: { getAuthorsLinks({ authors: $article.authors }) }</p>
                            </div>
                            }
                        </div>
                    </div>
                </div>
            </div>
        );
    });

    const bullets = slides.length > 1 ? (
        <ol class="carousel-indicators pb-3">
            {
            slides.map( (slide, $i) => {
                const $bullet_class = $i == 0 ? 'active' : '';
                return (
                    <li data-target={`#${$slider_id}`} data-slide-to={$i}
                        class={`d-flex align-items-center justify-content-center ${$bullet_class}`}>
                        <p>{ $i + 1}</p>
                    </li>
                );
            } )
            }
        </ol>
    ) : null;

    return (
        <div class="slider-micrositio ta-context micrositio ambiental my-3">
            <div class="context-bg">
                <div id={$slider_id} class="carousel slide context-color pt-3" data-ride="carousel">
                    <div class="carousel-inner">
                        { slides }
                    </div>
                    {bullets}
                </div>
            </div>
        </div>
    );
}

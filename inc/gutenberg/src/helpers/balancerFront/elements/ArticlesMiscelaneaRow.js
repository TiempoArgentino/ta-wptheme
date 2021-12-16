/** @jsx createElement */
/*** @jsxFrag createFragment */
import { createElement, createFragment } from '../../jsx/jsx';
import { renderArticlePreview } from '../rowsElements';

export default function ArticlesMiscelaneaRow(props = {}){
    let {
        rowArgs = {},
        articles = [],
    } = props;

    if( articles?.length <= 0 )
        return null;

    let {
        deactivate_opinion_layout = false,
    } = rowArgs;
    const $featured = articles[0] ?? null;
    const $regular_1 = articles[1] ?? null;
    const $regular_2 = articles[2] ?? null;
    const $regular_3 = articles[3] ?? null;

    const $regular_config = {
        size: 'common',
        className: '',
        desktopHorizontal: true,
        deactivateOpinionLayout: deactivate_opinion_layout,
    };

    return (
        <div class="ta-articles-block d-flex flex-column flex-md-row mt-3 row">
            <div class="col-12 col-md-6">
                { renderArticlePreview({
                    articleData: $featured,
                    size: 'large',
                    className: '',
                    deactivateOpinionLayout: deactivate_opinion_layout,
                }) }
            </div>
            <div class="col-12 col-md-6">
                { $regular_1 && renderArticlePreview({ ...$regular_config, articleData: $regular_1 }) }
                { $regular_2 && renderArticlePreview({ ...$regular_config, articleData: $regular_2 }) }
                { $regular_3 && renderArticlePreview({ ...$regular_config, articleData: $regular_3 }) }
            </div>
        </div>
    );
}

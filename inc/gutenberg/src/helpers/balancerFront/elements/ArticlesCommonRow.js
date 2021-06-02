/** @jsx createElement */
/*** @jsxFrag createFragment */
import { createElement, createFragment } from '../../jsx/jsx';
import { renderArticlePreview } from '../rowsElements';

export default function ArticlesCommonRow(props = {}){
    let {
        rowArgs = {},
        articles = [],
    } = props;

    if( articles?.length <= 0 )
        return null;

    let {
        cells_amount = 4,
        cells_per_row = 4,
        fill = false,
        deactivate_opinion_layout = false,
    } = rowArgs;
    let $col_lg = 0;
    let $col_lg_fill = 0;
    let $leftovers = 0;
    let $preview_class = '';
    cells_amount = cells_amount == -1 ? articles.length : cells_amount;
    if( fill ){
        $leftovers = cells_amount % cells_per_row;
        $col_lg_fill = $leftovers ? 12 / $leftovers : 0;
    }

    if(cells_per_row <= 4)
        $col_lg = 12 / cells_per_row;
    else if( cells_per_row == 5 )
        $col_lg = 2;

    const previews = articles.map( ($article, $i) => {
        const $col_lg_size = $i < $leftovers ? $col_lg_fill : $col_lg;
        const $col_class = `col-lg-${$col_lg_size}`;
        const $size = $col_lg_size > 5 ? 'large' : 'common';
        const $class = `col-12 ${$col_class}`;

        return (
            <div class={$class}>
                { renderArticlePreview({
                    articleData: $article,
                    size: $size,
                    className: $preview_class,
                    deactivateOpinionLayout: $size,
                }) }
            </div>
        );
    });

    return (
        <div class="ta-articles-block row">
            {previews}
        </div>
    );
}

const { useState } = wp.element;
const { PanelBody } = wp.components;

import RBPostsSelector from '../../components/rb-posts-selector/rb-posts-selector.js';
import {LRArticlesFilters} from "../../components/lr-articles-filter/lr-articles-filter.js";
import {useLRArticlesTaxonomies} from '../../helpers/lr-articles-taxonomies/lr-articles-taxonomies.js';
import { useLRArticlesData } from '../../helpers/ta-article/lr-articles.js';

function useArticlesFetch({ postsQueryArgs, fetchArgs }){
    const {
        articlesData: items,
        articlesFetchStatus: {loading, error},
        updateArticlesData,
        totalPages,
    } = useLRArticlesData( {
        postsQueryArgs,
        fetchArgs,
    } );

    return {
        items,
        loading,
        error,
        totalPages
    };
}

export const LRArticlesSelector = (props = {}) => {
    const {
        articles = [],
        onSelectionChange = null,
        postsArgs = {},
        useTaxonomiesFilters = true,
        useAmountFilter = true,
        ...selectorProps
    } = props;

    const [filtersAttributes, setFiltersAttributes] = useState({
        amount: 10,
        tags: { terms: [], required: false},
        sections: { terms: [], required: false},
        authors: { terms: [], required: false},
    });

    const mergueFilterAttributes = (newAttributes) => {
        setFiltersAttributes({
            ...filtersAttributes,
            ...newAttributes,
        });
    };

    const lrTaxonomies = useTaxonomiesFilters ? useLRArticlesTaxonomies({
        usage: {tag: true, section: true, author: true},
        tagProps: filtersAttributes.tags,
        sectionProps: filtersAttributes.sections,
        authorProps: filtersAttributes.authors,
    }) : {};

    const setQueryFilters = (postsQueryArgs) => {
        if(useAmountFilter && filtersAttributes.amount !== null)
            postsQueryArgs.posts_per_page = filtersAttributes.amount;
        if(useTaxonomiesFilters && lrTaxonomies.taxQuery)
            postsQueryArgs.tax_query = lrTaxonomies.taxQuery;

        return postsQueryArgs;
    };

    const showFilters = () => useTaxonomiesFilters || useAmountFilter;

    return (
        <RBPostsSelector
            posts={articles}
            onSelectionChange={(articles) => onSelectionChange(articles)}
            fetchHook = { useArticlesFetch }
            getItemData = { (article) => {
                return {
                    id: article.ID,
                    detail: article.title,
                };
            }}
            postsArgs={{
                post_type: 'ta_article',
                with_thumbnail: true,
                posts_per_page: 10,
                ...postsArgs,
            }}
            filtersContent={showFilters() &&
                <PanelBody
                    title={"Filtros avanzados"}
                    icon="search"
                    initialOpen={false}
                >
                    <LRArticlesFilters
                        amountFilter={true}
                        mostRecentFilter={false}
                        taxonomiesData={lrTaxonomies}
                        attributes={filtersAttributes}
                        setAttributes={mergueFilterAttributes}
                        requiredTaxonomies={true}
                        layoutType={'compressed'}
                    />
                </PanelBody>
            }
            queryModifier={(postsQueryArgs) => setQueryFilters(postsQueryArgs)}
            labels = {{
                // noSelectedItems: LRLabels.noArticlesSelected,
            }}
            modalLabels = {{
                // submitLabel: LRLabels.accept,
                // openerLabel: LRLabels.selectArticles,
                // modalTitle: LRLabels.articles,
            }}
            itemsSelectorLabels = {{
                // noSelectableItemsLabel: LRLabels.noArticlesFound,
                // selectedItemsLabel: LRLabels.selectedArticles,
                // loadingItemsLabel: LRLabels.loadingArticles,
            }}
            {...selectorProps}
        />
    )
}

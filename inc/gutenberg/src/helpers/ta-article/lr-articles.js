import { useRbFetch } from '../rb-fetch-hoc/rb-fetch-hoc.js';
import {useLRArticlesTaxonomies} from '../lr-articles-taxonomies/lr-articles-taxonomies.js';
import {LRArticlesFilters} from "../../components/lr-articles-filter/lr-articles-filter.js";
import {LRArticlesSelector} from '../../components/lr-articles-selector/lr-articles-selector.js';
const { useState, useRef } = wp.element;
const { PanelBody } = wp.components;

/**
*	Expected to be used in blocks with articles filters attributes.
*	@param {mixed[]} attributes													The block attributes. Must contain articles filters attributes.
*	@param {function} setAttributes												The block's setAttributes function.
*	@param {object} taxonomiesFilters											Indicates with taxonomy filters to use.
*/
export function useTAArticlesManager( props = {} ){
	const {
		attributes,
		setAttributes,
		taxonomiesFilters = {tag: true, section: true, author: true, micrositio: true},
		extraQueryArgs = {},
	} = props;
	const mostRecentTurnedOff = useRef(false);
	const mostRecentWasActive = useRef(false);

	// Chequeamos si la opcion de mas recientes fue apagada en este render, lo que provocaria un fetch
	mostRecentTurnedOff.current = mostRecentWasActive.current && !attributes.most_recent;
	mostRecentWasActive.current = attributes.most_recent;

	//================================================
	//	RENDERS
	//================================================
	const renderArticlesControls = (props = {}) => {
		let {
			articlesFiltersProps = {},
		} = props;

		articlesFiltersProps = {
			amountFilter: true,
			mostRecentFilter: true,
			taxonomiesData: lrTaxonomies,
			attributes: attributes,
			setAttributes: setAttributes,
			requiredTaxonomies: true,
			...articlesFiltersProps,
		};

		return (
			<PanelBody
				title="Filtros de Articulos"
				icon=""
				initialOpen={false}
			>
				<LRArticlesFilters
					{...articlesFiltersProps}
				/>
				{!attributes.most_recent &&
				<PanelBody
					title="Artículos"
					icon=""
					initialOpen={false}
				>
					<>
						<LRArticlesSelector
							articles={articles}
							onSelectionChange={(articles) => onSelectionChange(articles)}
							postsArgs = {extraQueryArgs}
						/>
					</>
				</PanelBody>
				}
			</PanelBody>
		)
	}

	//================================================
	//	HELPERS
	//================================================
	const onSelectionChange = (currentSelected) => {
		const newIds = [];
		const newArticles = currentSelected.map((article) => {
			newIds.push(article.ID);
			return {
				data: article.ID,
				type: 'article_post',
			};
		});
		updateArticlesData(newIds);
		setAttributes({ articles_data: newArticles});//saves the new article
	};

	const hasOnlyOneTermFilter = () => {
		const { most_recent } = attributes;
		const { section, tag, author, micrositio } = lrTaxonomies;
		const hasUniqueSection = section && section.termsData && section.termsData.length == 1 ? section.termsData[0] : false;
		const hasUniqueTag = tag && tag.termsData && tag.termsData.length == 1 ? tag.termsData[0] : false;
		const hasUniqueAuthor = author && author.termsData && author.termsData.length == 1 ? author.termsData[0] : false;
		const hasUniqueMicrositio = micrositio && micrositio.termsData && micrositio.termsData.length == 1 ? micrositio.termsData[0] : false;

		if( hasUniqueSection && !hasUniqueTag && !hasUniqueAuthor && !hasUniqueMicrositio )
			return hasUniqueSection;
		if( hasUniqueTag && !hasUniqueSection && !hasUniqueAuthor && !hasUniqueMicrositio )
			return hasUniqueTag;
		if( hasUniqueAuthor && !hasUniqueTag && !hasUniqueSection && !hasUniqueMicrositio )
			return hasUniqueAuthor;
		if( hasUniqueMicrositio && !hasUniqueAuthor && !hasUniqueTag && !hasUniqueSection )
			return hasUniqueMicrositio;

		return false;
	};


	//================================================
	//	QUERY ARGS SETUP
	//================================================
	const lrTaxonomies = useLRArticlesTaxonomies({
		usage: taxonomiesFilters,
		tagProps: attributes.tags,
		sectionProps: attributes.sections,
		authorProps: attributes.authors,
		micrositioProps: attributes.micrositios,
	});

	let postsQueryArgs = {
		post_type: 'ta_article',
		...extraQueryArgs,
	};

	if(attributes.most_recent){
		postsQueryArgs = {
			posts_per_page: attributes.amount,
			tax_query: lrTaxonomies.taxQuery,
			...postsQueryArgs,
		};
	}
	else{
		postsQueryArgs = {
			post__in: attributes.articles_data ? attributes.articles_data.map((article) => article.data) : null,
			only_include: true,
			orderby: 'post__in',
			with_thumbnail: true,
			...postsQueryArgs,
		};
	}

	//================================================
	//	DATA FETCH & SET
	//================================================

	const {
		articlesData: articles,
		articlesFetchStatus,
		updateArticlesData,
		triggerFetch,
	} = useLRArticlesData( {
		fetchArgs: {
			// Forzamos fetchs cuando estamos en mas recientes, o se cambia de mas recientes a seleccion manual
			updateOnArgsChange: mostRecentTurnedOff.current || attributes.most_recent,
		},
		postsQueryArgs,
	} );

	const {loading: loadingArticles, error: articlesFetchError} = articlesFetchStatus;
	// const articlesPosts = articlesData ? articlesData.map( (article) => article.post ) : null;

	// const {
	// 	articles,
	// 	fetching: fetchingArticles,
	// 	error: articlesFetchError,
	// } = useTAArticles({
	// 	queryArgs: 'test',
	// });
	// console.log(articles);
	//

	return {
		loadingArticles,
		articlesFetchError,
		articles,
		renderArticlesControls,
		isTermArticles: hasOnlyOneTermFilter(),
		triggerFetch,
	};
}

/**
*	Fetchea y guarda los datos de articulos en base a query args
*	Luego del primer fetch, si los articulos cambian se debe correr
*	reorganizeOrFetchArticles, que actualiza articlesData.
*	@return {json}
*		@property {LR_Article[]} articlesData
*			Array con los datos de los articulos actuales
*		@property {function} reorganizeOrFetchArticles
*			Reorganiza o fetchea los datos de articulos. Si los ids pasados se encuentran
*			en el articlesData actual, se reoganiza y no se realiza el fetch.
*			@param {int[]} newArticlesIds
*				Array con las ids de los articulos a guardar. Si alguno de estos articulos
*				no se encuentra en articlesData, se realiza un fetch
*		@property {mixed} articlesFetchData
*			Datos del fetch
*		@property {mixed} articlesFetchStatus
*			Estado del fetch
*			@property {bool} loading
*			@property {bool} error
*/
export function useLRArticlesData( args = {} ){
	const {
		postsQueryArgs = {},
		fetchArgs = {},
		initialArticles = [],
	} = args;
	const [ articlesData, setArticlesStateData ] = useState( initialArticles );
	const [ needsFetch, setNeedsFetch ] = useState( true );
	const needsPostsStateUpdate = useRef( true );
	const setArticlesData = ( stateValue ) => {
		setArticlesStateData( stateValue );
	};

	// Checks if there are new articles to fetch, or if it only has to reorganize the current set
	const updateArticlesData = (newArticlesIds) => {
		const articlesState = checkArticlesState(newArticlesIds, articlesData);
		if(!articlesState.needsFetch)
			setArticlesData(articlesState.articlesData);
		else
			setNeedsFetch(true);
	}

	// Do fetch only when query args changed, or when manually updating articles data and
	// and a required article is not in articlesData
	const updateOnArgsChange = needsFetch || fetchArgs && fetchArgs.updateOnArgsChange;
	const { articles: articlesFetchData, status: articlesFetchStatus, totalPages, triggerFetch } = useLRArticlesFetch( {
		...fetchArgs,
		updateOnArgsChange: updateOnArgsChange,
		onThen: ({responseData}) => {
			setArticlesStateData(responseData);
			setNeedsFetch(false);
		},
		postsQueryArgs: {
			with_thumbnail: true,
			...postsQueryArgs,
		},
	} );

	return {
		articlesFetchData, articlesFetchStatus, articlesData, setArticlesData, updateArticlesData, totalPages, triggerFetch
	};
}

/**
*	Chequea si alguna id de newArticlesIds no se encuentra en articlesData
*	para determinar si se necesita un fetch, o solo reorganizar
*	@param {int[]} newArticlesIds
*		Ids de los articulos a guardar
*	@param {LR_Article[]} articlesData
*		Array con los articulos que se tienen actualmente
*	@return {json}
*		@property {bool} needsFetch
*			Indica si se necesita fetch o no
*		@property {bool} orderChanged
*			Indica si cambio el orden de los articulos (cuando no se requiere fetch)
*		@property {LR_Article[]|[]} articlesData
*			El articlesData actualizada (cuando no se requiere fetch)
*/
const checkArticlesState = (newArticlesIds, articlesData) => {
	let newArticlesData = [];
	let orderChanged = false;
	let needsFetch = false;

	if( newArticlesIds.length > articlesData.length ){
		needsFetch = true;
	}
	else{
		for( let i = 0; i < newArticlesIds.length; i++){
			const articleID = newArticlesIds[i];
			const index = articlesData.findIndex( (article) => article.ID == articleID );
			if(index == -1){
				needsFetch = true;
				break;
			}

			if( i != index )
				orderChanged = true;

			const articleData = articlesData[index];
			newArticlesData.push(articleData);
		}
	}

	return {
		needsFetch: needsFetch ? needsFetch : false,
		orderChanged,
		articlesData: newArticlesData,
	};
};

export function useLRArticlesFetch( props ) {
	props = props ? props : {};
	const {
		postsQueryArgs = {},
		...fetchArgs
	} = props;

	const { response, responseData, status, triggerFetch } = useRbFetch( '/ta/v1/articles', {
		...fetchArgs,
		restPath: '/ta/v1/articles',
		method: 'POST',
		queryArgs: postsQueryArgs,
		data: { args: postsQueryArgs },
		parse: false,
	} );

	return {
		articles: responseData,
		totalPages: response && response.headers ? parseInt( response.headers.get( 'X-WP-TotalPages' ) ) : 0,
		status,
		response,
		triggerFetch,
	};
}


export function isArticlePostType(postType){
	return postType == 'ta_article' || postType == 'ta_fotogaleria' || postType == 'ta_audiovisual';
}

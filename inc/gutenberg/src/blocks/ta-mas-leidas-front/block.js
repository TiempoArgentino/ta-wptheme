import TAFrontBalancedRow from '../../components/TAFrontBalancedRow/TAFrontBalancedRow';
import { fetchBalancedArticles } from '../../helpers/balancerFront/balancerRow';
import { fetchLatestMostViewedPosts } from '../../helpers/postsViewCount/postsViewCount';
const { apiFetch } = wp;

( async ($) => {
	if(typeof window.postsBalancer === 'undefined')
		return;


	$(document).ready( async () => {
		const mostViewedList = document.querySelectorAll(".ta-most-read-articles");
		const removeMostViewedComponents = () => mostViewedList.forEach( item => $(item).closest('.ta-user-tabs-block').slideUp().remove() );

		// No hay bloques de Mas Leidas
		if(!mostViewedList.length)
			return;

		try {
			let articlesData;
			let {
				success: mostViewedFetchSuccess,
				data: mostViewedArticlesData,
			} = await fetchLatestMostViewedPosts({
				show: 5,
				// days_ago: 30,
			}) ?? {};

			if(!mostViewedFetchSuccess || !mostViewedArticlesData?.length) {
				removeMostViewedComponents();
				return;
			}

			const mostViewedArticlesIds = mostViewedArticlesData.map( article => article.post_id );

			/**
			*	@function fixArticlesOrder
			*	Puts the articles returned by the Latest Articles API in order by
			*	amount of views.
			*/
			function fixArticlesOrder(){
				const sortedMostViewedArticles = [];
				mostViewedArticlesIds.forEach( (articleID) => {
			    	const article = articlesData.find( article => article.postId == articleID );
				    if( article )
				        sortedMostViewedArticles.push(article);
				});
				articlesData = sortedMostViewedArticles;
			}

			// Final arguments for most reads api
			const articlesArgs = {
				maxDays: TABalancerApiData?.masLeidasDaysAgo ?? 10,
				amounts: {
					mostViewed: mostViewedArticlesIds.length,
				},
				userPreference: {},
				mostViewed: mostViewedArticlesIds,
				ignore: [],
			};

			articlesData = await fetchBalancedArticles({ articlesArgs });

			if(articlesData?.length)
				fixArticlesOrder();

			// fixArticlesOrder can change the length of the array it is checked again
			if(articlesData?.length) {
				mostViewedList.forEach((mostViewedList, i) => {
					// Actualizamos los datos (titulo, imagen y link) en los previews placeholder de cada bloque de mas leidas
					$(mostViewedList).find('.article-preview').each( function(index){
						const { url, title, imgURL: thumbnailUrl } = articlesData[index] ?? {};

						if(!url || !title){ // No hay datos para mostrar, ocultamos placeholder
							$(this).slideUp(400, function(){
								$(this).remove();
							});
						}
						else { // Actualizamos datos placeholder
							$(this).find(`[data-link]`).attr('href', url);
							$(this).find(`[data-title]`).html(title);
							$(this).find(`[data-thumbnail]`).css('background-image', `url(${thumbnailUrl})`);
						}
					} );
				});
			}
			else { // Ocultamos cada bloque de mas leidas
				removeMostViewedComponents();
			}

		} catch (e) { // Ocultamos cada bloque de mas leidas
			removeMostViewedComponents();
			console.log('ERROR', e);
		}

	} );


})(jQuery)

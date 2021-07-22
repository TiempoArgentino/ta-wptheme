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
			let {
				success: mostViewedFetchSuccess,
				data: mostViewedArticlesData,
			} = await fetchLatestMostViewedPosts({
				show: 5,
			}) ?? {};

			if(!mostViewedFetchSuccess || !mostViewedArticlesData?.length) {
				removeMostViewedComponents();
				return;
			}

			const mostViewedArticlesIds = mostViewedArticlesData.map( article => article.post_id );
			console.log('mostViewedArticlesIds', mostViewedArticlesIds);

			// Final arguments for most reads api
			const articlesArgs = {
				amounts: {
					mostViewed: mostViewedArticlesIds.length,
				},
				userPreference: {},
				mostViewed: mostViewedArticlesIds,
				ignore: [],
			};

			// TODO: Si hay un error, ocultar las mas leidas
			const articlesData = await fetchBalancedArticles({ articlesArgs });

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
							$(this).find(`[data-title]`).text(title);
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

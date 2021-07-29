import TAFrontBalancedRow from '../../components/TAFrontBalancedRow/TAFrontBalancedRow';
import { fieldsScheme, forEachField, getUserPreferenceForAPI, getUserViewedArticlesIds } from '../../helpers/balancerFront/scheme';
import { userCompletedPersonalization, userDeniedPersonalization, getCloudLocalStorageIds } from '../../helpers/balancerFront/anonymousPersonalization';
import { renderBalancerArticlesRow } from '../../helpers/balancerFront/balancerRow';
import { fetchLatestMostViewedPosts } from '../../helpers/postsViewCount/postsViewCount';
import './tagsCloud';
import './balancerIcons';

async function getMostViewedArticlesIds(){
	let {
		success: mostViewedFetchSuccess,
		data: mostViewedArticlesData,
	} = await fetchLatestMostViewedPosts() ?? {};

	return mostViewedFetchSuccess && mostViewedArticlesData?.length ? mostViewedArticlesData.map( article => article.post_id ) : [];
}

// TODO: REMOVE LOGS
( async ($) => {
	if(typeof window.postsBalancer === 'undefined')
		return;

	try {
		let taPreferences = await getUserPreferenceForAPI();

		$(document).ready( async () => {
			const balancedRows = document.querySelectorAll(".ta-articles-balanced-row");
			let currentRowIndex = 0;
			let fetchedArticles = [];
			let mostViewedArticlesIds = [];
			let ignoredArticles = await getUserViewedArticlesIds();

			try {
				mostViewedArticlesIds = await getMostViewedArticlesIds() ?? [];
			} catch (e) {
				console.log('ERRRO', e);
			}

			ignoredArticles = TABalancerApiData?.articlesShownOnRender?.length > 0 ? [...ignoredArticles, ...TABalancerApiData.articlesShownOnRender] : ignoredArticles;
			if(ignoredArticles.length)
				mostViewedArticlesIds = mostViewedArticlesIds.filter( id => ignoredArticles.indexOf( id ) < 0 );

			function shiftFromMostViewed(amount){
				return mostViewedArticlesIds.splice(0, amount);
			}

			function getPercentage(total, percentage){
				return Math.ceil( total * parseInt(percentage) / 100 );
			}

			function getAmounts(cellsCount){
				const userPreference = getPercentage(cellsCount, postsBalancerData.percentages.user);
				let mostViewed = getPercentage(cellsCount, postsBalancerData.percentages.views);
				if(userPreference + mostViewed > cellsCount)
					mostViewed -= (userPreference + mostViewed) - cellsCount;
				const editorial = cellsCount - userPreference - mostViewed;
				return {
					userPreference,
					mostViewed,
					editorial,
				};
			}

			async function renderNextRow(){
				const rowElem = balancedRows[currentRowIndex];
				const rowArgs = $(rowElem).data('row');
				const cellsCount = $(rowElem).data('count');
				const amounts = getAmounts(cellsCount);
				const mostViewed = shiftFromMostViewed(amounts.mostViewed);

				// If amounts differ from actual mostViewed amount
				if(mostViewed.length < amounts.mostViewed){
					const mostViewedDif = amounts.mostViewed - mostViewed.length;
					amounts.mostViewed -= mostViewedDif;
					amounts.editorial += mostViewedDif;
				}

				// Final arguments
				const articlesArgs = {
					maxDays: TABalancerApiData?.balancerDaysAgo ?? 20,
					amounts,
					userPreference: taPreferences,
					mostViewed,
					ignore: [...ignoredArticles, ...fetchedArticles],
				};
				// console.log('articlesRequestArgs', articlesArgs);

				const renderedArticlesIds = await renderBalancerArticlesRow({ elem: rowElem, articlesArgs, rowArgs, cellsCount });
				fetchedArticles = renderedArticlesIds?.length ? [...fetchedArticles, ...renderedArticlesIds] : fetchedArticles;

				if(currentRowIndex < balancedRows.length - 1){
					currentRowIndex++;
					renderNextRow();
				}
			}

			if(balancedRows && balancedRows.length)
				renderNextRow();
		} );
	}
	catch (e) {
		const balancedRows = document.querySelectorAll(".ta-articles-balanced-row");
		balancedRows.forEach( balancedRow => balancedRow.remove() );
		console.log(e);
	}

})(jQuery)

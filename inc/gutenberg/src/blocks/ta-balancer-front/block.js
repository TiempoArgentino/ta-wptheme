import TAFrontBalancedRow from '../../components/TAFrontBalancedRow/TAFrontBalancedRow';
import { fieldsScheme, forEachField, getUserPreferenceForAPI, getUserViewedArticlesIds } from '../../helpers/balancerFront/scheme';
import { userCompletedPersonalization, userDeniedPersonalization, getCloudLocalStorageIds } from '../../helpers/balancerFront/anonymousPersonalization';
import { renderBalancerArticlesRow } from '../../helpers/balancerFront/balancerRow';
import './tagsCloud';
import './balancerIcons';


// TODO: REMOVE LOGS
( async ($) => {
	if(typeof window.postsBalancer === 'undefined')
		return;

	let fetchedArticles = [];
	let ignoredArticles = await getUserViewedArticlesIds();
	let mostViewedArticlesIds = TABalancerApiData?.mostViewed ? [...TABalancerApiData.mostViewed] : [];
	if(ignoredArticles.length)
		mostViewedArticlesIds = mostViewedArticlesIds.filter( id => ignoredArticles.indexOf( id ) < 0 );
	console.log('mostViewedArticlesIds', mostViewedArticlesIds);

	function shiftFromMostViewed(amount){
		return mostViewedArticlesIds.splice(0, amount);
	}

	function getPercentage(total, percentage){
		return Math.ceil( total * parseInt(percentage) / 100 );
	}

	// TODO: Que pasa si cellsCount es 1?
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

	try {
		let taPreferences = await getUserPreferenceForAPI();

		$(document).ready( async () => {
			const  { render } = wp.element;
			const balancedRows = document.querySelectorAll(".ta-articles-balanced-row");
			let currentRowIndex = 0;
			ignoredArticles = TABalancerApiData?.articlesShownOnRender?.length > 0 ? [...ignoredArticles, ...TABalancerApiData.articlesShownOnRender] : ignoredArticles;

			const renderNextRow = async () => {
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
					amounts,
					userPreference: taPreferences,
					mostViewed,
					ignore: [...ignoredArticles, ...fetchedArticles],
				};
				console.log('articlesRequestArgs', articlesArgs);

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

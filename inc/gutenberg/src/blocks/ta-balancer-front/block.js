import TAFrontBalancedRow from '../../components/TAFrontBalancedRow/TAFrontBalancedRow';
import { userCompletedPersonalization, userDeniedPersonalization, getCloudLocalStorageIds } from '../../helpers/balancerFront/anonymousPersonalization';
import './balancerIcons';
import { fieldsScheme, forEachField, getUserPreferenceForAPI } from '../../helpers/balancerFront/scheme';

// TODO: REMOVE LOGS
( async ($) => {
	let fetchedArticles = [];
	const mostViewedArticlesIds = TABalancerApiData && TABalancerApiData.mostViewed ? [...TABalancerApiData.mostViewed] : [];
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

	if(!postsBalancer)
		return;

	try {
		let taPreferences = await getUserPreferenceForAPI();

		$(document).ready( async () => {
			const  { render } = wp.element;
			const balancedRows = document.querySelectorAll(".ta-articles-balanced-row");
			let currentRowIndex = 0;

			const renderNextRow = () => {
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
				const articlesRequestArgs = {
					amounts,
					userPreference: taPreferences,
					mostViewed,
					ignore: fetchedArticles,
				};
				console.log('articlesRequestArgs', articlesRequestArgs);

				render(
					<TAFrontBalancedRow
						rowArgs = {rowArgs}
						cellsCount = {cellsCount}
						articlesRequestArgs = { articlesRequestArgs }
						onArticlesFetched = { ({articlesIds}) => {
							fetchedArticles = [...fetchedArticles, ...articlesIds];
							if(currentRowIndex < balancedRows.length - 1){
								currentRowIndex++;
								renderNextRow();
							}
						} }
					/>
				, rowElem);
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

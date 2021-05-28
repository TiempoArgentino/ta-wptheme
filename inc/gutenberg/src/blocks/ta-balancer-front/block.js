import TAFrontBalancedRow from '../../components/TAFrontBalancedRow/TAFrontBalancedRow';
import {userCompletedPersonalization, userDeniedPersonalization, getCloudLocalStorageIds} from './tagsCloud.js';

( ($) => {
	let fetchedArticles = [];
	const mostViewedArticlesIds = taMostViewed && taMostViewed.ids ? [...taMostViewed.ids] : [];
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

	$(document).ready( async () => {
		if(!postsBalancer)
			return;

		try {
			let taPreferences = {};
			// If logged and has selected tags from the tags cloud
			// it doesn't use the data from the balancer (current post data, etc)
			if(!postsBalancerData.isLogged && userCompletedPersonalization()){
				taPreferences.tags = getCloudLocalStorageIds();
			}
			else{
				const userPreference = await postsBalancer.loadPreferences();
				taPreferences = {
					authors: userPreference.info.authors,
					tags: userPreference.info.tags,
					sections: userPreference.info.cats,
				};
			}

			const  { render } = wp.element;
			const balancedRows = document.querySelectorAll(".ta-articles-balanced-row");
			let currentRowIndex = 0;

			function renderNextRow(){
				const rowElem = balancedRows[currentRowIndex];
				const rowArgs = $(rowElem).data('row');
				const cellsCount = $(rowElem).data('count');
				const amounts = getAmounts(cellsCount);
				const articlesRequestArgs = {
					amounts,
					userPreference: taPreferences,
					mostViewed: shiftFromMostViewed(amounts.mostViewed),
					ignore: fetchedArticles,
				};
				console.log('articlesRequestArgs', articlesRequestArgs);

				render(
					<TAFrontBalancedRow
						rowArgs = {rowArgs}
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

			renderNextRow();
		}
		catch (e) {
			const balancedRows = document.querySelectorAll(".ta-articles-balanced-row");
			balancedRows.forEach( balancedRow => balancedRow.remove() );
			console.log(e);
		}
	} );

})(jQuery)

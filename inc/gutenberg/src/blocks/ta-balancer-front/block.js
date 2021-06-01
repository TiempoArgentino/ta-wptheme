import TAFrontBalancedRow from '../../components/TAFrontBalancedRow/TAFrontBalancedRow';
import { userCompletedPersonalization, userDeniedPersonalization, getCloudLocalStorageIds } from './tagsCloud';
import './balancerIcons';
import { fieldsScheme, forEachField } from '../../helpers/balancerFront/scheme';

// TODO: REMOVE LOGS
( ($) => {
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

	/**
	*	Takes the user preference data from the balancer, and maps its fields to
	*   the one expected by the Tiempo Argentino latest articles API
	*/
	function mapFromUserPreferenceToAPIFields(userPreference){
		const hasPreferences = userPreference && userPreference.info;
		const taPreferences = {};

		forEachField( ({ fieldName, fieldData }) => {
			const { default: defaultVal, apiField } = fieldData;
			const userPrefValue = hasPreferences ? userPreference.info[fieldName] : null;
			taPreferences[apiField] = userPrefValue ? userPrefValue : defaultVal;
		} );

		return taPreferences;
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
				taPreferences = mapFromUserPreferenceToAPIFields(userPreference);
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
		}
		catch (e) {
			const balancedRows = document.querySelectorAll(".ta-articles-balanced-row");
			balancedRows.forEach( balancedRow => balancedRow.remove() );
			console.log(e);
		}
	} );

})(jQuery)

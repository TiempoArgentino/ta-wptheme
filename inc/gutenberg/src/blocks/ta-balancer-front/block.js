import TAFrontBalancedRow from '../../components/TAFrontBalancedRow/TAFrontBalancedRow';

( ($) => {

	$(document).ready( () => {
		const  { render } = wp.element;

		const fetchedArticlesIds = [];
		const balancedRows = document.querySelectorAll(".ta-articles-balanced-row");
		let currentRowIndex = 0;

		function renderNextRow(){
			const rowElem = balancedRows[currentRowIndex];
			const rowArgs = $(rowElem).data('row');
			render(
				<TAFrontBalancedRow
					rowArgs = {rowArgs}
					onArticlesFetched = { () => {
						if(currentRowIndex < balancedRows.length - 1){
							currentRowIndex++;
							renderNextRow();
						}
					} }
				/>
			, rowElem);
		}

		renderNextRow();
	} );

})(jQuery)

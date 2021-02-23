( function( $ ) {
	var fontawesomeCodes = faw_vars.fontawesomeCodes;
	
	function icon(prefix, code, active){
		var faClass = iconClass(prefix, code);
		var activeClass = active ? ' active ' : '';
		return "<i title='"+ code +"' class='"+ faClass + activeClass +" fa-control-icon-option' data-fa-code='"+ faClass +"'></i>";
	}

	function iconClass(prefix, code){
		return prefix + ' fa-' + code;
	}

	//Resturns array with the codes that includes the query
	function getFilteredCodes(query){
		var result = [];
		if( query.length > 0){
			query = query.toLowerCase();
			fontawesomeCodes.brands.forEach(function(code){
				if( code.includes(query) )
					result.push({prefix: 'fab', code: code});
			});
			fontawesomeCodes.regular.forEach(function(code){
				if( code.includes(query) )
					result.push({prefix: 'far', code: code});
			});
			fontawesomeCodes.solid.forEach(function(code){
				if( code.includes(query) )
					result.push({prefix: 'fas', code: code});
			});
		}
		return result;
	}

	//Loads the results from the search
	function loadResults($controlPanel, query){
		var $searchList = getSearchListElement($controlPanel);
		var results = getFilteredCodes(query);
		var html = "";
		results.forEach(function(fa){
			var active = iconClass(fa.prefix, fa.code) == getCurrentCode($controlPanel);
			html += icon(fa.prefix, fa.code, active);
		});
		$searchList.html(html);
	}

	//Returns the div in where the results from the search will be displayed
	function getSearchListElement($controlPanel){
		return $controlPanel.find('.fa-search-list');
	}

	//Returns the hidden input that triggers the change of the control
	function getValueInput($controlPanel){
		return $controlPanel.find('[rb-control-value]');
	}

	//Returns the current icon element
	function getCurrentIconElement($controlPanel){
		return $controlPanel.find('.current-fa > i');
	}

	function getCurrentCode($controlPanel){
		return $controlPanel.attr('data-fa-current');
	}

	//Changes the current icon and triggers the control change to be saved
	function changeCurrentIcon( $controlPanel, faCode ){
		var currentIcon = getCurrentIconElement($controlPanel);
		var valueInput = getValueInput($controlPanel);
		currentIcon.removeClass();
		currentIcon.addClass(faCode);
		$controlPanel.attr('data-fa-current', faCode);
		valueInput.val(faCode).trigger( 'input' );
	}

	$(document).on('input', '.fa-control .fa-search', function(){
		var $controlPanel = $(this).closest('.fa-control');
		var query = $(this).val();
		loadResults($controlPanel, query);
	});

	$(document).on('click', '.fa-control .fa-control-icon-option', function(){
		var $controlPanel = $(this).closest('.fa-control');
		var newCode = $(this).attr('data-fa-code');
		if( getCurrentCode($controlPanel) != newCode ){
			var faClass = '.' + newCode;
			faClass = faClass.replace(" ", ".");
			changeCurrentIcon( $controlPanel, newCode );
			$controlPanel.find('.fa-control-icon-option.active').removeClass('active');
			$controlPanel.find('.fa-control-icon-option' + faClass).addClass('active');
		}
	});

} )( jQuery );

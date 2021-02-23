( function( $ ) {

	function getNewSortableListOrder( $sortableList ){
		var counter = 0;
		var newOrderString = "";
		var amountOfItems = $sortableList.children('li').length;

		$sortableList.children('li').each(function () {
			console.log(this);
			newOrderString += ($(this).attr('name'));
			if ( amountOfItems != (counter + 1) )
				newOrderString += ',';
			counter++;
		});

		return newOrderString;
	}

	$(document).ready(function(){
		setTimeout(function(){
			$(".customize-control-sortable-list .sortables-ul").sortable({
				update: function(event, ui) {
					//$item.find('ol.dropdown-menu').sortable('enable');
					var $item = ui.item;
					$item.parents( ".sortables-ul" ).find( 'input[type="hidden"]' ).val( getNewSortableListOrder($item.parents( ".sortables-ul" )) ).trigger( 'change' );
				}
			});
			$(".textarea-generator-sorstable-ul").sortable({
				update: function(event, ui) {
					var $item = ui.item;
					console.log("drop");
				}
			});
		}, 1)
	})
} )( jQuery );

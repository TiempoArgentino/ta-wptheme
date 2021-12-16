(function($){
	// Add Color Picker to all inputs that have 'color-field' class
	$(document).ready(function(){
		$('.rb-color-picker').each(function(){
			var palettesAttr = $(this).attr('data-palettes');
			var palettes = palettesAttr ? JSON.parse(palettesAttr) : true;
			$(this).wpColorPicker({
				default: false,
				palettes: palettes,
			});
		});
	});

})(jQuery);

(function($){
    function getPanel( $item ){
        return $item.closest('.rb-image-selection-control');
    }

    function getRadioValue($panel){
        var radioName = $panel.find('.image-option > .image-option-input').attr('name');
        return document.querySelector(`input[name="${radioName}"]:checked`).value;
    }

    function getValueInput($panel){
        return $panel.find('[rb-control-value]');
    }

    function updateValue($panel){
        var value = getRadioValue($panel);
        var $input = getValueInput( $panel );
        $input.val(value).trigger('input');
    }

    $(document).on('input', '.rb-image-selection-control .image-option > .image-option-input', function(){
        var $panel = getPanel($(this));
        updateValue($panel);
    });

})(jQuery);

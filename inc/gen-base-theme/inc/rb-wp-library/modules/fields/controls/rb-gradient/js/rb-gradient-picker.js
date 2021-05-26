( function($){

    function duplicateSelectedHandler(gp){
        let selectedHandler = gp.getSelected();
        if(!selectedHandler)
            return;
        let position = selectedHandler.position > 99 ? selectedHandler.position - 1 : selectedHandler.position + 1;
        gp.addHandler(position, selectedHandler.color);
    }

    function updatePreview($panel, gp){
        var $preview = $panel.find('.preview');
        if(!$preview.length)
            return;

        $preview.css('background-image', gp.getSafeValue());
    }

    function initializeColorPicker($panel){
        let value = $panel.find('[rb-control-value]').val();
        value = value ? JSON.parse(value) : {};

        var gp = new Grapick({
            el: $panel.find('.gradient-picker-holder')[0],
            direction: value.direction ? value.direction : 'top',
            type: value.type ? value.type : 'linear',
        });

        if(value.handlers)
            value.handlers.forEach((handler) => gp.addHandler(handler.position, handler.color));

        console.log(gp);
        return gp;
    }

    function updateValue($panel, gp){
        let value = {
            direction: gp.getDirection(),
            type: gp.getType(),
            value: gp.getSafeValue(),
            handlers: gp.handlers,
        };
        value = JSON.stringify(value);
        $panel.find('[rb-control-value]').val(value).trigger('input');
        //console.log(value, gp);
    }

    $(document).on('click', '.rb-gradient-picker-control .gradient-picker-creator', function(){
        var $panel = $(this).closest('.rb-gradient-picker-control');
        var $typeSelector = $panel.find('.switch-type');
        var $angleSelector = $panel.find('.switch-angle');
        //Show controls, hide button
        $(this).slideUp();
        $panel.find('.controls-container').slideDown();

        //Create gradient picker
        var gp = initializeColorPicker($panel);
        updatePreview($panel, gp);

        //SAVE VALUE
        gp.on('change', complete => {
            updateValue($panel, gp);
            updatePreview($panel, gp)
            ////console.log(gp.getSafeValue(), gp);
        });

        //TYPE SELECTOR
        //console.log($typeSelector, gp.getType());
        $typeSelector.val(gp.getType());
        $typeSelector.on('change', function(){
            gp.setType(this.value);
        });
        //DIRECTION SELECTOR
        $angleSelector.val(gp.getDirection());
        $angleSelector.on('change', function(){
            gp.setDirection(this.value);
        });

        //DUPLICATE HANDLER
        $panel.on('click', '.duplicate-selected', function(e){
            console.log(gp);
            duplicateSelectedHandler(gp);
        });
    });

})( jQuery );

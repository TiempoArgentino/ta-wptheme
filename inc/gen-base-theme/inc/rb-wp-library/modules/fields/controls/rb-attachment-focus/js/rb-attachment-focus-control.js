(function($){

    function adaptSelectionOverlay($controlPanel){
        var value = getValue($controlPanel);
        var $overlay = $controlPanel.find('.selection-overlay-container .overlay');
        //WIDTH
        if(value.checkWidthFrom == 'right'){
            $overlay.css({
                left: 0,
                width: `${value.widthPercentage}%`,
            });
        }
        else if(value.checkWidthFrom == 'left'){
            $overlay.css({
                left: `${value.widthPercentage}%`,
                width: '100%',
            });
        }

        //HEIGHT
        if(value.checkHeightFrom == 'bottom'){
            $overlay.css({
                top: 0,
                height: `${value.heightPercentage}%`,
            });
        }
        else if(value.checkHeightFrom == 'top'){
            $overlay.css({
                top: `${value.heightPercentage}%`,
                height: '100%',
            });
        }
    }

    function getValue($controlPanel){
        var value = {
            widthPercentage: parseFloat($controlPanel.find('.width-percentage').text()),
            heightPercentage: parseFloat($controlPanel.find('.height-percentage').text()),
            checkWidthFrom: $controlPanel.find('.width-option').val(),
            checkHeightFrom: $controlPanel.find('.height-option').val(),
        };
        return value;
    }

    function setValue($controlPanel){
        var value = getValue($controlPanel);
        $input = $controlPanel.find('[rb-control-value]');
        if($input.length)
            $input.val( JSON.stringify(value) ).trigger('input').trigger('change');
    }

    $(document).on('change', '.rb-attachment-focus-control select.option', function(){
        var $controlPanel = $(this).closest('.rb-attachment-focus-control');
        adaptSelectionOverlay($controlPanel);
        setValue($controlPanel);
    });

    $(document).on('hover.xPointerInitializaton',  ".pointer.x-pointer", function(){
        if($(this).hasClass('dragging-attached'))
            return;
        $(this).addClass('dragging-attached');

        $( ".pointer.x-pointer" ).draggable({
            containment: ".attachment-image-container",
            axis: "x",
            drag: function( event, ui ) {
                var $controlPanel = $(this).closest('.rb-attachment-focus-control');
                var $image = $(this).closest('.attachment-image-container').first('img');
                var $pointer = $(this);

                if(!$image.length || !$pointer.length)
                    return;

                ui.position.left = ui.position.left < 0 ? 0 : ui.position.left;
                ui.position.top = ui.position.top < 0 ? 0 : ui.position.top;

                var widthPercentage = (ui.position.left * 100 / $image[0].clientWidth).toFixed(2);
                ui.position.left = `${widthPercentage}%`;

                $pointer.css({
                    left: `${widthPercentage}%`,
                });

                adaptSelectionOverlay($controlPanel);
                $controlPanel.find('.width-percentage').text(widthPercentage);
            },
            stop: function(event, ui){
                var $controlPanel = $(this).closest('.rb-attachment-focus-control');
                setValue($controlPanel);
            },
        });
    });

    $(document).on('hover.yPointerInitializaton',  ".pointer.y-pointer", function(){
        if($(this).hasClass('dragging-attached'))
            return;
        $(this).addClass('dragging-attached');

        $( ".pointer.y-pointer" ).draggable({
            containment: ".attachment-image-container",
            axis: "y",
            drag: function( event, ui ) {
                var $controlPanel = $(this).closest('.rb-attachment-focus-control');
                var $image = $(this).closest('.attachment-image-container').first('img');
                var $pointer = $(this);

                if(!$image.length || !$pointer.length)
                    return;

                ui.position.left = ui.position.left < 0 ? 0 : ui.position.left;
                ui.position.top = ui.position.top < 0 ? 0 : ui.position.top;

                var heightPercentage = (ui.position.top * 100 / $image[0].clientHeight).toFixed(2);
                ui.position.top = `${heightPercentage}%`;

                $pointer.css({
                    top: `${heightPercentage}%`,
                });

                adaptSelectionOverlay($controlPanel);
                $controlPanel.find('.height-percentage').text(heightPercentage);
            },
            stop: function(event, ui){
                var $controlPanel = $(this).closest('.rb-attachment-focus-control');
                setValue($controlPanel);
            },
        });
    });

})(jQuery);

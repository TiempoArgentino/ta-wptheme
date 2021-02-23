(function($){
    function getPanel( $item ){
        return $item.closest('.rb-double-list-control');
    }

    function getValueInput( $panel ){
        return $panel.find('[rb-control-value]');
    }

    function getItems( $panel ){
        return $panel.find('.items .item');
    }

    function getItemValue( $item ){
        return {
            name: $item.find('.name > input').val(),
            value: $item.find('.value > input').val(),
        }
    }

    function updateValue( $panel ){
        var $items = getItems( $panel );
        var value = [];
        if( $items ){
            $items.each(function(){
                value.push( getItemValue( $(this) ) );
            });
        }
        //console.log(value);
        var $input = getValueInput( $panel );
        $input.val( JSON.stringify(value) ).trigger('input');
    }

    function getEmptyItem( $panel ){
        var htmlString = $panel.attr('data-empty-item');
        return htmlString;
    }

    function addItem( $panel ){
        $panel.find('.items').append( getEmptyItem($panel) );
        updateValue($panel);
    }

    function removeItem( $panel, $item ){
        $item.remove();
        updateValue($panel);
    }

    $(document).on('click', '.rb-double-list-control > .add-item-button-container .add-item', function(){
        var $panel = $(this).closest('.rb-double-list-control');
        addItem($panel);
    });

    $(document).on('click', '.rb-double-list-control > .items > .item > .delete-button', function(){
        var $panel = $(this).closest('.rb-double-list-control');
        var $item = $(this).closest('.item');
        removeItem($panel, $item);
    });

    $(document).on('input', '.rb-double-list-control > .items > .item input', function(){
        var $panel = $(this).closest('.rb-double-list-control');
        updateValue($panel);
    });

    $(document).ready(function(){
        $('.rb-double-list-control > .items').sortable({
            forcePlaceholderSize: true,
            update: function( event, ui ){
                //If the sorting stopped and the order changes, update value
                var $panel = getPanel(ui.item);
                updateValue($panel);
            },
        });
    });

})(jQuery);

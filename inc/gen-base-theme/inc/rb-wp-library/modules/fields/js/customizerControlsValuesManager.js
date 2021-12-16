( function($){
    $(document).ready(function(){

        $(document).on('input change', '[rb-control-value]', function(){
            $panel = $(this).closest('.rb-customizer-control');
            if($panel.length != 0){
                updateValue($panel);
            }
        });

        function updateValue($panel){
            var value = '';
            var $controlInput = $panel.children('[rb-customizer-control-value]');

            if( groupType.isGroup($panel) )
                value = groupType.getValue($panel);
            else if( singleType.isSingle($panel) )
                value = singleType.getValue($panel);

            console.log(value);
            $controlInput.val(value).trigger('change');
        }


        // =========================================================================
        // Manages the value of a group type control field
        // =========================================================================
        var groupType = {
            getValue: function($panel){
                var finalValue = {};

                if( this.isGroup($panel) ){
                    var $inputs = $panel.find('[rb-control-value]');
                    var groupID = this.getGroupBaseID($panel);
                    console.log(groupID);
                    $inputs.each(function(){
                        var key = $(this).attr('name').replace(groupID + '-','');
                        finalValue[key] = $(this).val();
                    });
                }
                console.log(finalValue);
                return JSON.stringify(finalValue);
            },
            isGroup: function($panel){
                return $panel.children('.rb-group-field').length != 0;
            },
            getGroupBaseID: function($panel){
                return $panel.children('.rb-group-field').attr('data-id');
            }
        }

        // =========================================================================
        // Manages the value of a single type control field
        // =========================================================================
        var singleType = {
            getValue: function($panel){
                var finalValue = '';

                if( this.isSingle($panel) ){
                    var $input = $panel.find('[rb-control-value]').first();
                    if( $input.length != 0 )
                        finalValue = $input.val();
                }
                console.log(finalValue);
                return finalValue;
            },
            isSingle: function($panel){
                return $panel.children('.rb-single-field').length != 0;
            },
        }
    });
})( jQuery );

$(document).ready(function(){
    function RB_Filters_Panel($panel, settings){
        this.$panel = $panel;
        this.$filters = $panel.find('[data-filter]');
        this.filters = []; //array of RB_Filter
        this.value = {};
        this.settings = settings;

        //Saves the current filters panel value on the html attr data-value
        this.updateValueOnHtml = function(){
            this.$panel.attr('data-value', JSON.stringify(this.value) );
        }

        //Updates the value of a single filter, of id == filterID
        this.updateFilterValue  = function( filterID, value ){
            this.value[filterID] = value;
            this.updateValueOnHtml();

            if( this.settings && this.settings.onValueUpdated )
                this.settings.onValueUpdated( this );
            //console.log( this.value );
        };

        //Update the values of all the inputs
        this.updateValue = function(){
            var newValue = {};
            this.filters.forEach( function(filter){
                newValue[filter.id] = filter.getValue();
            });
            this.updateValueOnHtml();
            this.value = newValue;
        };

        //Generates the RB_Filter from the $filters element
        this.generateFilters = function(){
            var panel = this;
            this.$filters.each(function(){
                panel.filters.push( new RB_Filter($(this), panel)  );
            });
            console.log(panel.filters);
        };

        //Initialization
        this.initialize = function(){
            this.generateFilters();
            this.updateValue();
        };

        this.initialize();
    }

    function RB_Filter($filter, panel){
        this.id = $filter.attr('data-id');
        this.panel = panel; //Panel that holds the filter
        this.$filter = $filter;
        this.type = radioType; //Type of filter. It manages the value
        this.value = ''; //Current value

        this.updateValue = function(){
            this.value = this.getValue();
            this.panel.updateFilterValue( this.id, this.value);//updates the value on the panel
        };

        this.getValue = function(){
            return this.type.getFilterValue(this.$filter);
        };

        this.setFilterType = function(){
            var filterType = this.$filter.attr('data-type');
            switch(filterType){
                default: this.type = radioType; break;
            }
        };

        this.initialize = function(){
            this.setFilterType();

            var filter = this;
            this.$filter.on('click', '[data-option]', function(){
                filter.type.toggleOption( filter, $(this) );
                filter.updateValue();
            });
        };

        this.initialize();
    }

    var radioType = {
        toggleOption: function(filter, $option){
            if( $option.hasClass('selected') )
                $option.removeClass('selected');
            else
                $option.addClass('selected', '');
        },
        getFilterValue: function($filter){
            var value = [];
            if( $filter.length ){
                var $options = $filter.find('[data-option]');
                if( $options.length ){
                    $options.each(function(){
                        if( $(this).hasClass('selected') )
                            value.push( $(this).attr('data-value') );
                    });
                }
            }
            return value;
        },
    };


    $('.rb-wp-filters').each(function(){
        new RB_Filters_Panel($(this), {
            onValueUpdated: function( panel ){
                var filterValues = panel.value;
                //Not using lambda functions for ie11 support
                var ageCats = filterValues.age ? filterValues.age.map( function(e){ return parseInt(e); } ) : [];
                var sizeCats = filterValues.size ? filterValues.size.map( function(e){ return parseInt(e); } ) : [];
                var foodTypeCats = filterValues.food_type ? filterValues.food_type.map( function(e){ return parseInt(e); } ) : [];
                //var avaibleCats = ageCats.concat(sizeCats, foodTypeCats);


                $('.post-box').stop().fadeOut( function(){
                    $('.post-box').each( function(){
                        var prodCats = JSON.parse($(this).attr('data-cats'));
                        var ageIntersection = prodCats.filter( function(id){ return -1 !== ageCats.indexOf(id); } );
                        var sizeIntersection = prodCats.filter( function(id){ return -1 !== sizeCats.indexOf(id); } );
                        var foodTypeIntersection = prodCats.filter(function(id){ return -1 !== foodTypeCats.indexOf(id); } );

                        var isCorrectAge = ageCats.length == 0 || ageIntersection.length > 0
                        var isCorrectSize = sizeCats.length == 0 || sizeIntersection.length > 0;
                        var isCorrectFoodType = foodTypeCats.length == 0 || foodTypeIntersection.length > 0;

                        if( isCorrectAge && isCorrectSize && isCorrectFoodType )
                            $(this).stop().fadeIn();

                    });
                });
            }
        });
    });
});

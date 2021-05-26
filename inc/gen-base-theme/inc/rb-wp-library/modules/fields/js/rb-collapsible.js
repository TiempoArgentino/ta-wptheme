(function($){
    class RBCollapsibleMaster{
        constructor(){

        }

        static isCollapsible($collapsible){
            return $collapsible.hasClass('rb-collapsible');
        }

        static collapsibleIsOpen($collapsible){
            return $collapsible.hasClass('active');
        }

        static animationStarts($collapsible){
            $collapsible.addClass('animating');
        }

        static animationOver($collapsible){
            $collapsible.removeClass('animating');
        }

        static closeCollapsible($collapsible, time){
            var $body = $collapsible.children('.rb-collapsible-body');
            var time = time ? time : 200;

            RBCollapsibleMaster.animationStarts($collapsible)
            $body.stop().slideUp(time, function(){
                $collapsible.removeClass('active');
                $collapsible.removeClass('animating');
            });
        }

        static openCollapsible($collapsible){
            var $body = $collapsible.children('.rb-collapsible-body');

            $collapsible.addClass('opening');
            RBCollapsibleMaster.animationStarts($collapsible);
            $body.stop().slideDown({
                duration: 200,
                start: function () {
                    $(this).css('display', 'block');
                },
                complete: function () {
                    RBCollapsibleMaster.animationOver($collapsible);
                    $collapsible.removeClass('opening');
                    $collapsible.addClass('active');
                    $body.height('auto');
                },
            });
        }

        static toggleCollapsible($collapsible){
            if( RBCollapsibleMaster.collapsibleIsOpen($collapsible) )
                RBCollapsibleMaster.closeCollapsible($collapsible);
            else
                RBCollapsibleMaster.openCollapsible($collapsible);
        }

        static activateAccordion($accordion, $collapsible){
            //console.log($accordion, $collapsible)
            if( !$collapsible.hasClass('animating') ){
                var $siblings = $collapsible.siblings('.rb-collapsible');
                if( !$siblings.hasClass('animating')){
                    RBCollapsibleMaster.toggleCollapsible($collapsible);
                    $siblings.each(function(){
                        if( RBCollapsibleMaster.collapsibleIsOpen($(this)) )
                            RBCollapsibleMaster.closeCollapsible($(this));
                    });
                }
            }
        }
    }
    window.RBCollapsibleMaster = RBCollapsibleMaster;

    $(document).on('click', '.rb-collapsible > .rb-collapsible-header', function(){
        var $collapsible = $(this).closest('.rb-collapsible');
        var $accordion = $collapsible.parent('.rb-accordion');
        if($accordion.length > 0)
            RBCollapsibleMaster.activateAccordion($accordion, $collapsible);
        else
            RBCollapsibleMaster.toggleCollapsible($collapsible);
    });
})(jQuery);

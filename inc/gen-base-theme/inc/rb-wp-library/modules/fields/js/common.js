( function($){
    // =========================================================================
    // IMAGE ZOOM
    // =========================================================================
    function getGalleryImages($gallery){
        return $gallery.children('[rb-zoom-src]');
    }

    function getImageSrc($el){
        var src = '';
        console.log($el.attr('rb-zoom-src'));
        if ( $el.attr('rb-zoom-src') )
            src = $el.attr('rb-zoom-src');
        else if ( $el.is('img') && $el.attr('src') )
            src = $el.attr('src');
        else if ( $el.css('background-image') )
            src = $el.css('background-image').replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
        return src;
    }

    $(document).on('click', '[rb-zoom-gallery]', function(){

    });

    function prepareZoomViewHtml(){
        var $zoomContainer = $('.rb-image-zoom-container');
        var $rbZoomed = $($.parseHTML( '<img class="rb-zoomed"/>' ));
        if( $zoomContainer.length == 0  ){
            $zoomContainer = $($.parseHTML( '<div class="rb-image-zoom-container"></div>' ));
            $zoomContainer.append($rbZoomed);
            $('body').append( $zoomContainer );
        }
        else if ($zoomContainer.find('.rb-zoomed').length == 0){
            $zoomContainer.append( $rbZoomed );
        }
        else{
            $rbZoomed = $zoomContainer.find('.rb-zoomed');
        }
        return $zoomContainer;
    }

    function openRbZoomView($img){
        var $zoomContainer = prepareZoomViewHtml();
        var $rbZoomed = $zoomContainer.find('.rb-zoomed');

        var isOpen = $zoomContainer.hasClass('open');
        var isAnimating = $zoomContainer.hasClass('animating');
        if(!isOpen && !isAnimating){
            $zoomContainer.addClass('animating');
            setTimeout(function(){
                var imageSrc = getImageSrc($img);
                console.log(imageSrc);
                if( imageSrc != '' ){
                    $rbZoomed.attr('src', imageSrc );
                    $zoomContainer.addClass('open');
                    $zoomContainer.animate({
                        'opacity':  1,
                    }, 200, function(){
                        $zoomContainer.removeClass('animating');
                    })
                    $zoomContainer.addClass('open');
                }
            }, 10);
        }
        return $zoomContainer;
    }

    var rbZoomGallery = {
        sources: [],
        index: 0,
        $container: null,
        getSrc: function(index){
            return this.sources[index];
        },
        changeSrc: function(src){
            this.$container.find('.rb-zoomed').attr('src', src);
        },
        goNext: function(){
            var length = this.sources.length;
            if( this.index == (length - 1) )
                this.index = 0;
            else
                this.index++;

            console.log(this.index);
            this.changeSrc(this.sources[this.index]);
        },
        goPrev: function(){
            var length = this.sources.length;
            if( this.index == 0 )
                this.index = length - 1;
            else
                this.index--;

            this.changeSrc(this.sources[this.index]);
        },
        initialize: function($zoomContainer, src, index){
            this.sources = src;
            this.index = index;
            console.log(index);
            this.$container = $zoomContainer;
            this.$container.attr('rb-zoom-gallery-container', src);
            this.$container.attr('rb-not-close-on-click', true);
            this.$container.append('<div class="rb-zoom-gallery-close">x</div>');
        },
    }

    $(document).on('click', '[rb-zoom-gallery-container]', function(event){
        var x = event.clientX;
        console.log(x, window.innerWidth);
        if(x > window.innerWidth/2)
            rbZoomGallery.goNext();
        else
            rbZoomGallery.goPrev();
    });
    $(document).on('click', '.rb-image-zoom-container[rb-zoom-gallery-container] .rb-zoom-gallery-close', function(event){
        event.stopPropagation();
        rbZoomGallery.$container.removeAttr('rb-not-close-on-click');
        closeRbZoomContainer(rbZoomGallery.$container);
    });

    function transformToGallery($img, $zoomContainer){
        var sources = [];
        var $srcHolder = $img.parent('[rb-zoom-gallery]');
        var imageIndex = $srcHolder.find('[rb-zoom-src]').index($img);
        if($srcHolder.length){
            $srcHolder.children('[rb-zoom-src]').each(function(){
                sources.push($(this).attr('rb-zoom-src'));
            });
            $zoomContainer.attr('rb-zoom-gallery-container', sources);
            rbZoomGallery.initialize($zoomContainer, sources, imageIndex);
        }
    }

    $(document).on('click', '.rb-image-zoom', function(){
        var $zoomContainer = openRbZoomView($(this));
        transformToGallery($(this), $zoomContainer);
    });

    $(document).on('click', '.rb-image-zoom-container', function(){
        closeRbZoomContainer($(this));
    });

    function closeRbZoomContainer($zoomContainer){
        if( !$zoomContainer.hasClass('animating') && !$zoomContainer.attr('rb-not-close-on-click')){
            $zoomContainer.addClass('animating');
            $zoomContainer.animate({
                'opacity':  0,
            }, 200, function(){
                $zoomContainer.removeClass('open');
                $zoomContainer.removeClass('animating');
            })
        }
    }

})( jQuery );

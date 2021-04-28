(function($){
         $(document).ready(function(){
            $('#historial-see').on('click',function(){
                if($('#historial-all').is(':visible')){
                    $('#historial-all').slideUp();
                }
                $('#historial-taken').slideToggle();
            });
        });

        $(document).ready(function(){
            $('#historial-see-2').on('click',function(){
                if($('#historial-taken').is(':visible')){
                    $('#historial-taken').slideUp();
                }
                $('#historial-all').slideToggle();
            });
        });

        $(document).ready(function(){
            $('.delete-beneficio-user').on('click',function(){
                var post_id = $(this).data('id_beneficio');
                var user = $(this).data('user');
                if(confirm('Eliminar beneficio?')) {
                    $.ajax({
                        type:'post',
                        url:beneficios_theme_ajax.url,
                        data:{
                            action: beneficios_theme_ajax.action,
                            post_id:post_id,
                            user:user
                        },
                        success:function(res){
                            if(res){
                                $('#history-'+post_id).remove()
                            } else {
                                alert(res);
                            }
                        }
                    });
                }

            });
        });

        //Calcula height de art. destacado cuando es miscelanea
        $(document).ready(function(){
            if ($(window).width() >= 768) {
                $('.ta-articles-block.d-flex.flex-column .destacado .img-wrapper').css("height",$('.ta-articles-block.d-flex.flex-column .destacado .img-wrapper').height() + 26 + 'px');

                $( window ).resize(function() {
                    $('.ta-articles-block.d-flex.flex-column .destacado .img-wrapper').css("height", "initial");
                    $('.ta-articles-block.d-flex.flex-column .destacado .img-wrapper').css("height",$('.ta-articles-block.d-flex.flex-column .destacado .img-wrapper').height() + 26 + 'px');
                  });
            }
        });

        $(document).on('click','.abrir-beneficio',function(e){
            e.preventDefault();
            var id = $(this).data('content');

            if(!$(id).hasClass('show')){
                $(id).slideDown().addClass('show');
            } else {
                $(id).slideUp().removeClass('show');
            }

        });

        //Header sticky min y menu

        const desktop = window.matchMedia("(min-width: 768px)");
        var menuSticky = $("#menu");
        var headerStickyDesktop = $("#headerDefault");

        window.onscroll = function () {
            if (desktop.matches) {
                if (window.pageYOffset >= 140) {
                    headerStickyDesktop.addClass("sticky-default");
                    menuSticky.removeClass('menu-desktop');
                    menuSticky.addClass('menu-sticky-desktop');
                } else {
                    headerStickyDesktop.removeClass("sticky-default");
                    menuSticky.removeClass('menu-sticky-desktop');
                    menuSticky.addClass('menu-desktop');
                }
            } else {
                if (window.pageYOffset >= 65) {
                    headerStickyDesktop.removeClass("sticky-default");
                    menuSticky.addClass('menu-sticky-desktop');
                } else {
                    menuSticky.removeClass('menu-sticky-desktop');
                }
            }
        };

})(jQuery);

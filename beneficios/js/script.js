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
        $(document).ready(function () {
            if ($(window).width() >= 768) {
              $(".ta-articles-block.d-flex.flex-column .destacado .img-wrapper").css(
                "padding-bottom",
                parseInt(
                  $(
                    ".ta-articles-block.d-flex.flex-column .destacado .img-wrapper"
                  ).css("padding-bottom")
                ) +
                  27 +
                  "px"
              );
              /* $('.ta-articles-block.d-flex.flex-column .destacado .img-wrapper').css("height",$('.ta-articles-block.d-flex.flex-column .destacado .img-wrapper').height() + 26 + 'px'); */
        
              $(window).resize(function () {
                $(".ta-articles-block.d-flex.flex-column .destacado .img-wrapper").css(
                  "padding-bottom",
                  "66.66%"
                );
                $(".ta-articles-block.d-flex.flex-column .destacado .img-wrapper").css(
                    "padding-bottom",
                    parseInt(
                      $(
                        ".ta-articles-block.d-flex.flex-column .destacado .img-wrapper"
                      ).css("padding-bottom")
                    ) +
                      27 +
                      "px"
                  );
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
        var searchBar = $("#searchBar");

        window.onscroll = function () {
            if (desktop.matches) {
                if (window.pageYOffset > 140) {
                    $("body").css("padding-top", "139px");
                    headerStickyDesktop.addClass("sticky-default");
                    menuSticky.removeClass('menu-desktop');
                    menuSticky.addClass('menu-sticky-desktop');
                    searchBar.addClass('searchBarFixed');
                } else {
                    $("body").css("padding-top", "0");
                    headerStickyDesktop.removeClass("sticky-default");
                    menuSticky.removeClass('menu-sticky-desktop');
                    menuSticky.addClass('menu-desktop');
                    searchBar.removeClass('searchBarFixed');
                }
            } else {
                if (window.pageYOffset > 65) {
                    headerStickyDesktop.removeClass("sticky-default");
                    menuSticky.addClass('menu-sticky-desktop');
                } else {
                    menuSticky.removeClass('menu-sticky-desktop');
                }
            }
        };

})(jQuery);

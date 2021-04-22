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
})(jQuery);
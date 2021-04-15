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
})(jQuery);
(function($){
         $(document).ready(function(){
            $('#historial-see').on('click',function(){
                $('#historial-all').slideToggle();
            });
        });
    
        $(document).ready(function(){
            $('.delete-beneficio-user').on('click',function(){
                var post_id = $(this).data('id_beneficio');

                if(confirm('Eliminar beneficio?')) {
                    $.ajax({
                        type:'post',
                        url:beneficios_theme_ajax.url,
                        data:{
                            action: beneficios_theme_ajax.action,
                            post_id:post_id
                        },
                        success:function(res){
                            if(res){
                                $('#history-'+post_id).remove()
                            } else {
                                console.log(res);
                            }
                        }
                    });
                }
                
            });
        });
})(jQuery);
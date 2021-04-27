(function($){
   $(document).ready(function(){
        $('#borrar-articulos').on('click',function(){
            var id = $('#usuarios-borralos').val();

            $.ajax({
                type:'post',
                url:ajax_delete.url,
                data: {
                    action: ajax_delete.action,
                    nonce: ajax_delete.nonce,
                    id: id
                },
                success:function(res) {
                    const datos = res.data;
                    datos.forEach(function(dato,index) {
                        borrar(`${dato}`);
                    });
                },
                error:function(res) {
                    //console.log(res)
                }
            });
        });
   });

   function borrar(id_post) {
        setTimeout( () => {
            $.ajax({
                type:'post',
                url:ajax_delete_coso.url,
                data: {
                    action: ajax_delete_coso.action,
                    nonce: ajax_delete_coso.nonce,
                    id_post:id_post
                },
                success: function(res){
                    console.log(res.data)
                },
                error: function(res) {
                    console.log(res)
                }
               });
        },1000);
   }
})(jQuery);
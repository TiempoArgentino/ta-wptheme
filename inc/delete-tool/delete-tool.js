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
                if(res.success){
                    console.log(res);
                } else {
                    console.log('error ' + res);
                }
            },
            error:function(res) {
                console.log(res)
            }
        });
    });
   });
})(jQuery);
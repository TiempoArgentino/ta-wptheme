(function($){
    console.log('tiempo balancer');
    $(document).ready(function() {
        $('#personalize-city').on('keyup',function(){
           if($(this).val().length > 3){
               $.ajax({
                    type:'post',
                    url:balancer_place_ajax.url,
                    data: {
                        action: balancer_place_ajax.action,
                        b_search: $(this).val()
                    },
                    success: function(res){
                        $('#autocompletar').html(res);

                    },
                    error: function(res){
                        console.log(res)
                    }
               });
           }
        });
    });

    $(document).on('click','.suggest',function(){
        $('#personalize-city').val($(this).text());
        $('#suggest-ul').remove();
    });
})(jQuery);
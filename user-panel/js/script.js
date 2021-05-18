(function($){
    $("#address-button").click(function(event) {
        event.preventDefault();
        $(this).html('Guardar')
        $('.delivery-info .input-container').each(function(i, elem) {
            $(elem).addClass('editing');
            $(`.input-account`).prop('disabled',false);
        })

        $("#finishEditingDeliveryInfo").css({
            display: "block"
        });
    });

    $(document).on('click','#editDInfo' ,function(){
        $('#edit-delivery-form').submit();
    });

    $("#editPersonalInfo").click(function(event) {
        event.preventDefault();

        $('.personal-info .input-container').each(function(i, elem) {
            $(elem).addClass('editing')
             $(`.input-account`).prop('disabled',false);   
        })

        $("#finishEditingPersonalInfo").css({
            display: "block"
        });
        $(this).hide();
        $('#editInfo').show();
    });
    
    $(document).on('click','#editInfo',function(){
        $('#edit-info-form').submit();
    });

    $(document).on('click','.profile-data',function(){
        var contenido = $(this).data('open');
        if(!$(contenido).is(':visible')){
            $(contenido).slideDown();
        } else {
            $(contenido).slideUp();
        }
    });
})(jQuery);
(function($){
    $("#editDeliveryInfo").click(function(event) {
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

    $("#editPersonalInfo").click(function(event) {
        event.preventDefault();
        $(this).html('Guardar');
        $('.personal-info .input-container').each(function(i, elem) {
            $(elem).addClass('editing')
             $(`.input-account`).prop('disabled',false);   
        })

        $("#finishEditingPersonalInfo").css({
            display: "block"
        });
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
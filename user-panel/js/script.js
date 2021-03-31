(function($){
    $("#editDeliveryInfo").click(function(event) {
        event.preventDefault();
        $(this).html('Guardar')
        $('.delivery-info .input-container').each(function(i, elem) {
            $(elem).addClass('editing')
            $(`#${elem.id} input`).removeAttr('disabled');
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
            $(`#${elem.id} input`).removeAttr('disabled');
        })

        $("#finishEditingPersonalInfo").css({
            display: "block"
        });
    });
})(jQuery);
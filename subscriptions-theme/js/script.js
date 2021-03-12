(function($){
    $(document).ready(function(){
        $(".amount .price").on('click', function(event) {
            $(".continue-btn").removeClass('active');
            $(".amount button").removeClass('active');
            const buttonID = $(this).data("id");
            $("#button" + buttonID).addClass('active');
            $(this).addClass('active');
        });
       
        $('.open-price').on('click',function() {
            var min = $(this).data('min');
            $('#minimo').html('$' + min);
        });
       
        $('.login-btn').bind('click', function() {
            $('#warningDeliveryZones').addClass('active')
        });
        $('.close-popup').bind('click', function() {
            $('#warningDeliveryZones').removeClass('active')
        });
        $('#errorPagoBtn').bind('click', function() {
            $('#errorPago').addClass('active')
        });
        $('.close-popup').bind('click', function() {
            $('#errorPago').removeClass('active')
        });
        $('#pagoExitosoBtn').bind('click', function() {
            $('#pagoExitoso').addClass('active')
        });
        $('.close-popup').bind('click', function() {
            $('#pagoExitoso').removeClass('active')
        });
    
        $(".tema button").each(function(i, elem) {
            var chosenTopic = false
            $(elem).bind('click', function() {
                if (!chosenTopic) {
                    $(elem).addClass('active')
                } else {
                    $(elem).removeClass('active')
                }
                chosenTopic = !chosenTopic
            })
        });
    
        $(".articulo button").each(function(i, elem) {
            var chosenArticle = false
            $(elem).bind('click', function() {
                if (!chosenArticle) {
                    $(elem).addClass('active')
                } else {
                    $(elem).removeClass('active')
                }
                chosenArticle = !chosenArticle
            })
        });
    
    
        $(".foto button").each(function(i, elem) {
            var chosenPhoto = false
            $(elem).bind('click', function() {
                if (!chosenPhoto) {
                    $(elem).addClass('active')
                } else {
                    $(elem).removeClass('active')
                }
                chosenPhoto = !chosenPhoto
                $(`#${elem.id} .foto-checkbox`).prop('checked', chosenPhoto)
            })
        });
    });
  
    /** Arreglos */
    $(document).ready(function(){
        var p = $('.subscription-content p');
        var host = window.location.protocol + '//' + window.location.hostname;
        p.addClass('d-flex align-items-center');
        p.prepend(`<img src="${host}/wp-content/themes/tiempo-argentino/assets/img/marker-vermas.svg" class="item-subscription">`);
    });

    $(document).on('click','button.toggle',function(){
        var target = $(this).data('target');
        $(target).toggle();
    });
})(jQuery);
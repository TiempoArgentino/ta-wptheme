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
        $(this).hide();
        $('#address-button-2').show();
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

    $(document).ready(function () {

        $('#address-button').on('click', function(){
            $(this).hide();
            $('#loader-address').removeClass('d-none').addClass('d-block');
        });

        $("#address-button-2").on("click", function () {

          var state = $("#state").val();
          var city = $("#city").val();
          var address = $("#address").val();
          var number = $("#number").val();
          var floor = $("#floor").val();
          var apt = $("#apt").val();
          var zip = $("#zip").val();
          var bstreet = $("#bstreet").val();
          $.ajax({
            type: "post",
            url: ajax_address.url,
            data: {
              action: ajax_address.action,
              _ajax_nonce: ajax_address._ajax_nonce,
              add_address: ajax_address.add_address,
              state: state,
              city: city,
              address: address,
              number: number,
              floor: floor,
              apt: apt,
              zip: zip,
              bstreet: bstreet,
              observations: '',
            },
            success: function (result) {
              if (result.success) {
                location.reload();
              } else {
                  alert(result.data[0].message)
                $("#msg-ok").html(result.data[0].message);
              }
            },
            error: function (result) {
              console.log("error " + result);
            },
          });
        });
      });

})(jQuery);
(function ($) {
  function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }
  $(document).ready(function () {
    $(".amount .price").on("click", function (event) {

      $(".continue-btn").removeClass("active");
      $(".amount button").removeClass("active");
      const buttonID = $(this).data("id");
      $("#button" + buttonID).addClass("active");
      $(this).addClass("active");
    });

    $(".open-price").on("click", function () {
      var min = $(this).data("min");
      $("#minimo").html("$" + min);
    });

    $("#custom-next-2").on("click", function () {
      var val = $("#custom-price-input").val();
      var min = $("#custom-price-input").attr("min");

      if (parseInt(val) < parseInt(min)) {
        $("#custom-price-input").addClass("is-invalid");
        $("#custom-price-input").val(min);
        $(".info h6").addClass("text-danger");
        $("#minimum").html(
          '<strong class="text-center d-block text-danger">Recordá que el valor mínimo es $' +
          min +
          "</strong>"
        );
        return;
      }

      $("#custom-price-row").slideUp(400, function () {
        $("#login-register-loop").slideDown();
      });
    });

    $(".button-suscribe-1").on("click", function () {
      var price = $(this).data("price");
      var name = $(this).data("name");
      var paper = $(this).data("paper");
      var type = $(this).data("role");
      
      if (paper === 1) {
        $("#paper-option").hide();
      }
      if ($("#subscriptions-loop").is(":visible")) {
        $("#subscriptions-loop").slideUp(400, function () {
          $("#paquete-elegido").slideDown();
          $("#pack-name").html(name);
          $("#price-paquete").html(price);
        });
      }
    });

    $("#custom-next-2").on("click", function () {
      var price = $("#custom-price-input").val();
      var name = $("#custom-price-input").data("name");
      var paper = $(this).data("paper");

      if (paper === 1) {
        $("#paper-option").hide();
      }
      if ($("#custom-price-row").is(":visible")) {
        $("#custom-price-row").slideUp(400, function () {
          $("#paquete-elegido").slideDown();
          $("#pack-name").html(name);
          $("#price-paquete").html(price);
        });
      }
    });

    $("#login-button").on("click", function () {
      $("#paquete-elegido").slideUp(400, function () {
        $("#login-form").slideDown();
      });
    });

    $("#send-login").on("click", function () {
      var user = $("#username");
      var password = $("#password");

      if (user.val() === "") {
        user.addClass("border-danger");
        $(".username_error").html("El email es obligatorio.");
      }

      if (user.val() === "") {
        password.addClass("border-danger");
        $(".pass_error").html("El password es obligatorio.");
      }

      if (!isEmail(user.val())) {
        user.addClass("border-danger");
        $(".username_error").html("El Usuario debe ser un email.");
      }
    });

    $("#username").keypress(function () {
      if ($(this).val().length >= 3 && isEmail($(this).val())) {
        if ($(this).hasClass("border-danger")) {
          $(this).removeClass("border-danger");
        }
        $(".username_error").remove();
      }
    });

    $("#password").keypress(function () {
      if ($(this).val().length >= 3) {
        if ($(this).hasClass("border-danger")) {
          $(this).removeClass("border-danger");
        }
        $(".pass_error").remove();
      }
    });

    $("#register-button").on("click", function () {
      $("#paquete-elegido").slideUp(400, function () {
        $("#register-form").slideDown();
      });
    });

    $("#submit-register-2").on("click", function () {
      var name = $("#first_name");
      var last = $("#last_name");
      var email = $("#email");
      var passwd = $("#passwd");
      var passwd2 = $("#passwd2");

      if (name.val() === "") {
        name.addClass("border-danger");
        $(".first_name_error").html("El nombre es obligatorio.");
      }

      if (last.val() === "") {
        last.addClass("border-danger");
        $(".last_name_error").html("El apellido es obligatorio.");
      }

      if (email.val() === "" || !isEmail(email.val())) {
        email.addClass("border-danger");
        $(".email_error").html("Falta el email.");
      }

      if (passwd.val() === "") {
        passwd.addClass("border-danger");
        $(".password_error").html("La contraseña es obligatoria.");
      }

      if (passwd2.val() === "" || passwd2.val() !== passwd.val()) {
        passwd2.addClass("border-danger");
        $(".password2_error").html("Las contraseñas no coinciden.");
      }
    });

    $("#first_name").keypress(function () {
      if ($(this).val().length >= 3) {
        if ($(this).hasClass("border-danger")) {
          $(this).removeClass("border-danger");
        }
        $(".first_name_error").remove();
      }
    });

    $("#last_name").keypress(function () {
      if ($(this).val().length >= 3) {
        if ($(this).hasClass("border-danger")) {
          $(this).removeClass("border-danger");
        }
        $(".last_name_error").remove();
      }
    });

    $("#email").keyup(function () {
      if ($(this).val().length >= 3 && isEmail($(this).val())) {
        if ($(this).hasClass("border-danger")) {
          $(this).removeClass("border-danger");
        }
        $(".email_error").remove();
      }
    });

    $("#passwd").keypress(function () {
      if ($(this).val().length >= 3) {
        if ($(this).hasClass("border-danger")) {
          $(this).removeClass("border-danger");
        }
        $(".password_error").remove();
      }
    });

    $("#passwd2").keyup(function () {
      if ($(this).val().length >= 3 && $(this).val() === $("#passwd").val()) {
        if ($(this).hasClass("border-danger")) {
          $(this).removeClass("border-danger");
        }
        $(".password2_error").remove();
      }
    });

    $(".close-popup").bind("click", function () {
      $("#warningDeliveryZones").removeClass("active");
    });
    $("#errorPagoBtn").bind("click", function () {
      $("#errorPago").addClass("active");
    });
    $(".close-popup").bind("click", function () {
      $("#errorPago").removeClass("active");
    });
    $("#pagoExitosoBtn").bind("click", function () {
      $("#pagoExitoso").addClass("active");
    });
    $(".close-popup").bind("click", function () {
      $("#pagoExitoso").removeClass("active");
    });

    $(".tema button").each(function (i, elem) {
      var chosenTopic = false;
      $(elem).bind("click", function () {
        if (!chosenTopic) {
          $(elem).addClass("active");
        } else {
          $(elem).removeClass("active");
        }
        chosenTopic = !chosenTopic;
      });
    });

    $(".articulo button").each(function (i, elem) {
      var chosenArticle = false;
      $(elem).bind("click", function () {
        if (!chosenArticle) {
          $(elem).addClass("active");
        } else {
          $(elem).removeClass("active");
        }
        chosenArticle = !chosenArticle;
      });
    });

    $(".foto button").each(function (i, elem) {
      var chosenPhoto = false;
      $(elem).bind("click", function () {
        if (!chosenPhoto) {
          $(elem).addClass("active");
        } else {
          $(elem).removeClass("active");
        }
        chosenPhoto = !chosenPhoto;
        $(`#${elem.id} .foto-checkbox`).prop("checked", chosenPhoto);
      });
    });
  });

  /** Arreglos */
  $(document).ready(function () {
    var p = $(".subscription-content p");
    var host = window.location.protocol + "//" + window.location.hostname;
    p.addClass("d-flex align-items-center");
    p.prepend(
      `<img src="${host}/wp-content/themes/tiempo-argentino/assets/img/marker-vermas.svg" class="item-subscription">`
    );
  });

  // $(document).on('click','button.toggle',function(){
  //     var target = $(this).data('target');
  //     $(target).toggle();
  // });
  /**
   * Ajax
   */
  $(document).ready(function () {
    $(".button-suscribe-1").on("click", function () {
      
      var suscription_id = $(this).data("id");
      var suscription_price = $(this).data("price");
      var suscription_name = $(this).data("name");
      var suscription_type = $(this).data("type");
      var address = $(this).data("address");
      var type = $(this).data("role");

      $.ajax({
        type: "post",
        url: ajax_add_price_data.url,
        data: {
          action: ajax_add_price_data.action,
          _ajax_nonce: ajax_add_price_data._ajax_nonce,
          add_price: ajax_add_price_data.add_price,
          suscription_id: suscription_id,
          suscription_price: suscription_price,
          suscription_name: suscription_name,
          suscription_type: suscription_type,
          suscription_address: address,
          suscription_role: type
        },
        beforeSend: function (result) {
          // console.log('before ' + suscription_id);
        },
        success: function (result) {
          console.log('success ' + result);
        },
        error: function (result) {
          console.log("error " + result);
        }
      });
    });
  });
  /**
   * Custom price
   */
  $(document).ready(function () {
    $("#custom-next-2").on("click", function () {
      $.ajax({
        type: "post",
        url: ajax_add_custom_price_data.url,
        data: {
          action: ajax_add_custom_price_data.action,
          _ajax_nonce: ajax_add_custom_price_data._ajax_nonce,
          add_price_custom: ajax_add_custom_price_data.add_price_custom,
          suscription_id: $("#custom-price-input").data("id"),
          suscription_price: $("#custom-price-input").val(),
          suscription_name: $("#custom-price-input").data("name"),
          suscription_type: $("#custom-next-2").data("type"),
          suscription_address: $("#custom-price-input").data("address"),
          suscription_role: $('#custom-price-input').data('role')
        },
        beforeSend: function (result) {
          // console.log('before ' + suscription_id);
        },
        success: function (result) {
          console.log("success " + result);
        },
        error: function (result) {
          console.log("error " + result);
        }
      });
    });
  });

  $(document).ready(function () {
    $("#custom-price-input").on("keyup", function () {
      if ($(this).val().length >= 1) {
        $(".yellow-btn-white-text").css("color", "#252B2D");
      } else {
        $(".yellow-btn-white-text").css("color", "white");
      }
    });
    $(".form-check-input").on("click", function () {
      if ($(this).is(":checked")) {
        $(".payment-button-submit").css("color", "#252B2D");
      } else {
        $(".payment-button-submit").css("color", "white");
      }
    });
  });
  /**
   * Paper chose
   */

  $(document).on("click", "#payment-continue", function (e) {
    $(this).hide();
    $('#loader-address').removeClass('d-none').addClass('d-block');
    if ($("#add-paper").is(":checked")) {
      e.preventDefault();
      $.ajax({
        type: "post",
        url: ajax_add_paper.url,
        data: {
          action: ajax_add_paper.action,
          _ajax_nonce: ajax_add_paper._ajax_nonce,
          add_paper: ajax_add_paper.add_paper,
          price_paper: $("#add-paper").val()
        },
        success: function (res) {
          if (res) {
            window.location.href = $("#payment-continue a").attr("href");
          }
        },
        error: function (res) {
          console.log(res);
        }
      });
    }
  });

  $(document).ready(function () {
    if ($("#state").length > 0) {
      if ($("#state").val() !== "") {
        var host = window.location.protocol + "//" + window.location.hostname;
        var provincia = $("#state").val();
        var localidad = $("#localidad").val();

        $.getJSON(
          host +
          "/wp-content/themes/tiempo-argentino/subscriptions-theme/js/" +
          provincia +
          ".json",
          function (data) {
            $("#city").prop("disabled", false);
            var localidades = [];
            $.each(data, function (index, value) {
              localidades.push(
                '<option value="' +
                value.Localidad +
                '">' +
                value.Localidad +
                "</option>"
              );
            });

            $("#city").html(localidades);
            $("#city option[value='" + localidad + "']").attr(
              "selected",
              "selected"
            );
          }
        );
      }
    }


    $("#state").on("change", function () {
      var host = window.location.protocol + "//" + window.location.hostname;
      var provincia = $(this).val();
      var localidad = $("#localidad").val();

      $.getJSON(
        host +
        "/wp-content/themes/tiempo-argentino/subscriptions-theme/js/" +
        provincia +
        ".json",
        function (data) {
          $("#city").prop("disabled", false);
          var localidades = [];
          $.each(data, function (index, value) {
            var selected =
              $("#city").val() === localidad ? 'selected="selected"' : "";
            localidades.push(
              '<option value="' +
              value.Localidad +
              '" ' +
              selected +
              ">" +
              value.Localidad +
              "</option>"
            );
          });

          $("#city").html(localidades);
          $("#city option[value='" + localidad + "']").attr(
            "selected",
            "selected"
          );
        }
      );
    });
  });

  $(document).ready(function () {
      $('#paymentBank').prop('disabled', true);


      $('#terms-conditions_bank').on('click', function () {
        if ($(this).prop('checked')) {
          $('#paymentBank').prop('disabled', false);
        } else {
          $('#paymentBank').prop('disabled', true);
        }
      });

      $('#paymentBank').on('click', function () {
        var doc_type = $('#doc_type').val();
        var dni_number = $('#dni_number').val();
        var cbu_bank = $('#cbu_bank').val();
        var dni_bank = $('#dni_bank').val();

        

        if ($(this).prop('disabled', false)) {
          $('#paymentBank').hide();
          $('#loader-address-bank').removeClass('d-none').addClass('d-block');

          if(doc_type.length < 1){
            $('#doc_type').addClass('border-danger');
            paymentBankButton('#paymentBank');
          }
          if(dni_number.length < 7){
            $('#dni_number').addClass('border-danger');
            paymentBankButton('#paymentBank');
          }
          if(cbu_bank.length < 7){
            $('#cbu_bank').addClass('border-danger');
            paymentBankButton('#paymentBank');
          }
          if(dni_bank.length < 7){
            $('#dni_bank').addClass('border-danger');
            paymentBankButton('#paymentBank');
          }
        }
      });
  });

  function paymentBankButton(button){
     $(button).show();
     $('#loader-address-bank').removeClass('d-block').addClass('d-none');
  }
})(jQuery);

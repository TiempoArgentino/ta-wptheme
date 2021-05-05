const mq = window.matchMedia("(min-width: 992px)");
const dropdownList = document.getElementsByClassName("dropdown");
if (mq.matches) {
  for (let item of dropdownList) {
    item.classList.add("show");
  }
} else {
  for (let item of dropdownList) {
    item.classList.remove("show");
  }
}

window.addEventListener("resize", function () {
  if (mq.matches) {
    for (let item of dropdownList) {
      item.classList.add("show");
    }
  } else {
    for (let item of dropdownList) {
      item.classList.remove("show");
    }
  }
});

(function ($) {
  $(document).ready(function () {
    $(".tab-cooperativa").on("click", function () {
      $(".categorias-titulo").html("Seleccionar categoría");
      $(".member").show().addClass("d-flex");
      $(".select-categorias").val("");
    });

    $(".select-categorias").on("change", function () {
      var clase = $(this).val();
      var texto = $("option:selected", this).text();
      if (clase !== "") {
        $(".categorias-titulo").html(texto);
        $(".member")
          .not("." + clase)
          .removeClass("d-flex")
          .hide();
        $("." + clase)
          .show()
          .addClass("d-flex");
      } else {
        $(".member").show().addClass("d-flex");
      }
    });
  });

  $(document).ready(function () {
    $(".cerrar-pop").on("click", function () {
      $("#popup-avis").fadeOut(400, function () {
        $("#popup-avis").remove();
      });
    });

    $(".pop-mobile-close").on("touchstart", function () {
      $("#popup-avis").fadeOut(400, function () {
        $("#popup-avis").remove();
      });
    });

    setTimeout(function () {
      $("#popup-avis").fadeOut(400, function () {
        $("#popup-avis").remove();
      });
    }, 5000);

    $(".cerrar-pop-abajo").on("click", function () {
      $("#sticky-abajo").fadeOut(400, function () {
        $("#sticky-abajo").remove();
      });
    });

    $(".mobile-pop-close").on("touchstart", function () {
      $("#sticky-abajo").fadeOut(400, function () {
        $("#sticky-abajo").remove();
      });
    });

    $(".cerrar-vslider-desktop").on("click", function () {
      $("#vslider").fadeOut(400, function () {
        $("#vslider").remove();
      });
    });

    $(".cerrar-video-abajo").on("touchstart", function () {
      $("#vslider").fadeOut(400, function () {
        $("#vslider").remove();
      });
    });
  });

  $(document).ready(function () {
    $('form input[type="text"], form input[type="password"]').on(
      "keyup",
      function () {
        if (
          $('form input[type="text"], form input[type="password"]').last().val()
            .length > 6
        ) {
          $("button.yellow-btn-white-text").css("color", "#252b2d");
        } else {
          $("button.yellow-btn-white-text").css("color", "white");
        }
      }
    );
  });

 
})(jQuery);

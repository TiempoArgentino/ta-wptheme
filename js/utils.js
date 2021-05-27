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
  
  const url = "https://ws.smn.gob.ar/map_items/weather";

  $(document).ready(function () {
    var settings = {
      url: url,
      method: "GET",
      timeout: 0,
    };

    $.ajax(settings).done(function (response) {
      var data = response;
      $.each(data, function (i, e) {
        if (e.name === "Capital Federal") {
          $("#clima").html(`${e.weather.tempDesc}`);
        }
      });
    });
  });

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

  $(document).ready(function () {
    var link = $("li#wp-admin-bar-new-content a.ab-item:first-child").attr(
      "href"
    );
    $("li#wp-admin-bar-new-content a.ab-item:first-child").attr(
      "href",
      link + "?post_type=ta_article"
    );
  });

  $(document).ready(function () {
    var onboardingClose = localStorage.getItem("onboardingClose");

    if (!onboardingClose) {
      $("#asociate-popover").popover({
        container: ".asociate-popover .popover-container",
        placement: "bottom",
        trigger: "manual",
        template:
          '<div class="popover asociate" role="tooltip">' +
          '<div class="arrow">' +
          "</div>" +
          '<h3 class="popover-header">' +
          "</h3>" +
          '<div class="popover-body">' +
          "</div>" +
          "</div>",
        html: true,
        sanitize: false,
        title: function () {
          return (
            '<div class="d-flex justify-content-between align-items-start">' +
            '<p class="popover-title">Con tu aporte sostenés este medio</p>' +
            '<button type="button" id="close-1" class="close">' +
            '<img src="wp-content/themes/tiempo-argentino/assets/img/close.svg" class="img-fluid">' +
            "</button>" +
            "</div>"
          );
        },
        content: function () {
          return (
            "<p>Asociate a la comunidad</p>" +
            '<div class="d-flex justify-content-between align-items-end">' +
            '<span><img src="wp-content/themes/tiempo-argentino/assets/img/marker-tiempo.svg">paso 1 de 4</span>' +
            '<button id="go-to-2">siguiente</button>' +
            "</div>"
          );
        },
      });
      $("#personaliza-popover").popover({
        container: ".personaliza-popover .popover-container",
        placement: "bottom",
        trigger: "manual",
        template:
          '<div class="popover personaliza" role="tooltip">' +
          '<div class="arrow"></div>' +
          '<h3 class="popover-header"></h3>' +
          '<div class="popover-body">' +
          "</div>" +
          "</div>",
        html: true,
        sanitize: false,
        title: function () {
          return '<div class="d-flex justify-content-between align-items-start"><p class="popover-title">Personalizá tu experiencia de lectura</p><button type="button" id="close-2" class="close"><img src="wp-content/themes/tiempo-argentino/assets/img/close.svg" class="img-fluid"></button></div>';
        },
        content: function () {
          return '<p>Completá solo 3 pasos</p><div class="d-flex justify-content-between align-items-end"><span><img src="wp-content/themes/tiempo-argentino/assets/img/marker-tiempo.svg">paso 2 de 4</span><button id="go-to-3">siguiente</button></div>';
        },
      });

      $("#iconos-popover").popover({
        container: ".popovers",
        placement: "bottom",
        trigger: "manual",
        template:
          '<div class="popover iconos" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
        html: true,
        sanitize: false,
        title: function () {
          return (
            '<div class="d-flex justify-content-between align-items-start"><p class="popover-title">Tus preferencias se señalan en íconos:</p>' +
            '<button type="button" id="close-3" class="close"><img src="wp-content/themes/tiempo-argentino/assets/img/close.svg" class="img-fluid"></button></div>'
          );
        },
        content: function () {
          return (
            '<ul><li><img src="wp-content/themes/tiempo-argentino/assets/img/icon-img-1.svg">Autor favorito</li><li><img src="wp-content/themes/tiempo-argentino/assets/img/icon-img-2.svg">Tema de interés</li><li><img src="wp-content/themes/tiempo-argentino/assets/img/icon-img-3.svg">Relevante por localización</li></ul>' +
            '<div class="d-flex justify-content-between align-items-end"><span><img src="wp-content/themes/tiempo-argentino/assets/img/marker-tiempo.svg">paso 3 de 4</span>' +
            '<button id="go-to-4">siguiente</button></div>'
          );
        },
      });
      $("#config-popover").popover({
        container: ".config-popover .popover-container",
        placement: "bottom",
        trigger: "manual",
        template:
          '<div class="popover iconos" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
        html: true,
        sanitize: false,
        title: function () {
          return (
            '<div class="d-flex justify-content-between align-items-start"><p class="popover-title">Tus configuraciones y actividad</p>' +
            '<button type="button" id="close-4" class="close"><img src="wp-content/themes/tiempo-argentino/assets/img/close.svg" class="img-fluid"></button></div>'
          );
        },
        content: function () {
          return (
            "<p>Ingresá a tu panel de usuario y personalizá tu experiencia</p>" +
            '<div class="d-flex justify-content-between align-items-end"><span><img src="wp-content/themes/tiempo-argentino/assets/img/marker-tiempo.svg">paso 4 de 4</span>' +
            '<button id="end">entendido</button></div>'
          );
        },
      });

      //First popover
      $(".asociate-popover").insertAfter($(".header-content"));
      $("<div class='asociate-opacity-bg'></div>").insertAfter(
        $(".home .asociate-banner")
      );
      $(".asociate-banner").css("z-index", "200");
      $(document).on("click", "#go-to-2", goTo2);

      window.setTimeout(() => {
        $("#asociate-popover").popover("show");
      }, 500);

      function goTo2() {
        $(".asociate-opacity-bg").remove();
        $("<div class='personaliza-opacity-bg'></div>").insertAfter(
          $(".home .personaliza-popover")
        );
        $(".asociate-banner").css("z-index", "auto");
        $("#personaliza-popover").popover("show");
        $("#asociate-popover").popover("hide");
        $("html, body").animate(
          {
            scrollTop: $("#personaliza-popover").offset().top - 200,
          },
          500
        );
      }

      //Second popover
      $(".personaliza-popover").insertAfter($(".home .eleccion-contenido"));
      $(".home .eleccion-contenido").css("z-index", "200");

      $(document).on("click", "#go-to-3", goTo3);

      function goTo3() {
        $(".eleccion-contenido").css("z-index", "auto");
        $(".personaliza-opacity-bg").remove();
        $("<div class='iconos-opacity-bg'></div>").insertAfter(
          $(".iconos-popover").closest(".home .articles-block")
        );
        $("#iconos-popover").popover("show");
        $("#personaliza-popover").popover("hide");
        $("html, body").animate(
          {
            scrollTop: $("#iconos-popover").offset().top - 200,
          },
          500
        );
      }

      //Third popover
      $(".iconos-popover").insertAfter($(".home .icons-container").first());
      $(".home .icons-container")
        .first()
        .add(".article-icons")
        .css("z-index", "200");

      $(document).on("click", "#go-to-4", goTo4);

      function goTo4() {
        $(".hamburger-menu").css("z-index", "200");
        $(".icons-container")
          .first()
          .add(".article-icons")
          .css("z-index", "auto");
        $(".iconos-opacity-bg").remove();
        $("<div class='config-opacity-bg'></div>").insertAfter(
          $(".hamburger-menu")
        );
        $("#config-popover").popover("show");
        $("#iconos-popover").popover("hide");
      }

      //Fourth popover
      $(".config-popover").insertAfter($(".header-content"));

      $(document).on("click", "#end", endOnboarding);

      function endOnboarding() {
        $(".config-opacity-bg").remove();
        $("#config-popover").popover("hide");

        var end = localStorage.getItem("onboardingClose");
        if (!end) {
          localStorage.setItem("onboardingClose", true);
        }
      }

      $(document).on("click", ".close", cancelOnboarding);

      function cancelOnboarding() {
        $(".asociate-opacity-bg").remove();
        $(".personaliza-opacity-bg").remove();
        $(".iconos-opacity-bg").remove();
        $(".config-opacity-bg").remove();
        $("#asociate-popover").popover("hide");
        $("#personaliza-popover").popover("hide");
        $("#iconos-popover").popover("hide");
        $("#config-popover").popover("hide");

        var end = localStorage.getItem("onboardingClose");
        if (!end) {
          localStorage.setItem("onboardingClose", true);
        }
      }
    }
  });

  
})(jQuery);

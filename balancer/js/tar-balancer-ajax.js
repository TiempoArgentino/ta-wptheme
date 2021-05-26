(function ($) {
  //console.log('tiempo balancer');

  $(document).ready(function () {
    var tagOpen = localStorage.getItem('tagOpen');
    if(tagOpen) {
        $('#cloud-tag-container').hide();
    }

    $("#close-cloud-tag").on("click", function () {
      $("#cloud-tag-container").slideUp();
        
      
      if(!tagOpen || tagOpen === null) {
          localStorage.setItem('tagOpen',true);
      }

    });

    $('#listo-cloud').on('click',function(){
      if(!tagOpen || tagOpen === null) {
        localStorage.setItem('tagOpen',true);
    }
      $("#cloud-tag-container").slideUp();     
       
    });
  });

  

  $(document).ready(function () {
    $(".cloud-item").on("click", function () {
      var id = $(this).data("id");
      $(this).parent().parent().remove();
      $.ajax({
        type: "post",
        url: balancer_cloud_ajax.url,
        data: {
          action: balancer_cloud_ajax.action,
          id: id
        },
        success: function (res) {
           console.log(res);
        },
        error: function (res) {
          console.log(res);
        }
      });
    });
  });

  $(document).ready(function () {
    $("#personalize-city").on("keyup", function () {
      if ($(this).val().length > 3) {
        $.ajax({
          type: "post",
          url: balancer_place_ajax.url,
          data: {
            action: balancer_place_ajax.action,
            b_search: $(this).val()
          },
          success: function (res) {
            $("#autocompletar").html(res);
          },
          error: function (res) {
            console.log(res);
          }
        });
      }
    });
  });

  $(document).on("click", ".suggest", function () {
    $("#personalize-city").val($(this).text());
    $("#suggest-ul").remove();
  });

  $(document).ready(function () {
    $(".topic").on("change", function () {
      var temaID = $(this).attr("id");
      var temaIDSelector = $("#" + temaID);
      if ($(this).is(":checked")) {
        $(temaIDSelector).parent().parent().addClass("theme-selected");
      } else {
        $(temaIDSelector).parent().parent().removeClass("theme-selected");
      }
    });

    $(".post-item").on("change", function () {
      var temaID = $(this).attr("name");
      //var temaIDSelector = $('#' + temaID);
      if ($(this).is(":checked")) {
        $(this).parent().parent().addClass("art-selected");
      } else {
        $(this).parent().parent().removeClass("art-selected");
      }
    });

    $(".photo").on("change", function () {
      // var temaID = $(this).attr('name')
      // var temaIDSelector = $('#' + temaID);

      if ($(this).is(":checked")) {
        $(this).parent().parent().parent().addClass("photo-selected");
      } else {
        $(this).parent().parent().parent().removeClass("photo-selected");
      }
    });
  });

  $(document).ready(function () {
    if ($("#cloud-tag-topics").length) {
      var $div = $("#cloud-tag-topics .tag");
      if ($div.length > 6) {
        $div.slice(6, 16).removeClass("d-flex").addClass("d-none");
        $("#ver-mas-cloud").on("click", function () {
          $div.slice(0, 16).removeClass("d-none").addClass("d-flex");
        });
      }
    }
  });

})(jQuery);

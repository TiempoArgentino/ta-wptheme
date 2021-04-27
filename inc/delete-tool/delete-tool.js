(function ($) {
  $(document).ready(function () {
    $("#borrar-articulos").on("click", async function () {
        var id = $("#usuarios-borralos").val();
        var types = $("#types").val();
        const allIds = await $.ajax({
          type: "post",
          url: ajax_delete.url,
          data: {
            action: ajax_delete.action,
            nonce: ajax_delete.nonce,
            id: id,
            types: types,
          },
        });
        const datos = allIds.data;
        for (const dato of datos) {
          borrar(`${dato}`);
        }
      });
  });

  async function borrar(id_post) {
    let result;
    try {
      result = await $.ajax({
        type: "post",
        url: ajax_delete_coso.url,
        data: {
          action: ajax_delete_coso.action,
          nonce: ajax_delete_coso.nonce,
          id_post: id_post
        }
      });
      $('#mensaje-fin').html(result.data);
      return result;
    } catch (error) {
        $('#mensaje-fin').html(error.message);
    }
  }
})(jQuery);









(function ($) {
  $(document).ready(function () {
    $("#borrar-articulos").on("click",function(){
        coso();
    });
  });


  async function coso() {
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
    
    if(!datos)
        return;

    borrar(datos);
   
  }

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
      coso();
    } catch (error) {
        $('#mensaje-fin').html(error.message);
    }
  }
})(jQuery);

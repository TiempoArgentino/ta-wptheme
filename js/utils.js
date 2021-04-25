const mq = window.matchMedia('(min-width: 992px)');
const dropdownList = document.getElementsByClassName("dropdown");
if (mq.matches) {
    for (let item of dropdownList) {
        item.classList.add("show")
    }
} else {
    for (let item of dropdownList) {
        item.classList.remove("show")
    }
}

window.addEventListener('resize', function() {
    if (mq.matches) {
        for (let item of dropdownList) {
            item.classList.add("show")
        }
    } else {
        for (let item of dropdownList) {
            item.classList.remove("show")
        }
    }
});

(function($){
    $(document).ready(function(){
        $('.tab-cooperativa').on('click',function(){
            $('.categorias-titulo').html('Seleccionar categoría');
        });

        $('.select-categorias').on('change',function(){
            var clase = $(this).val();
            var texto = $('option:selected',this).text();
            if(clase !== ''){
                $('.categorias-titulo').html(texto);
                $('.member').not('.'+clase).removeClass('d-flex').hide();
                $('.'+clase).show().addClass('d-flex');
            } else {
                $('.member').show().addClass('d-flex');
            }
        })
    });
  
})(jQuery);
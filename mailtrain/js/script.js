(function($){
    $(document).ready(function(){
        $(".articulo button").each(function(i, elem) {
            var chosenTopic = false
            $(elem).bind('click', function() {
                if (!chosenTopic) {
                    $(elem).addClass('active')
                } else {
                    $(elem).removeClass('active')
                }
                chosenTopic = !chosenTopic
                $(`#${elem.id} .topic-checkbox`).prop('checked', chosenTopic)
            })
        });
    
        $(".medio button").each(function(i, elem) {
            var chosenOpt = false
            $(elem).bind('click', function() {
                if (!chosenOpt) {
                    $(elem).addClass('active')
                } else {
                    $(elem).removeClass('active')
                }
                chosenOpt = !chosenOpt
            })
        });
    
        // $('.next-btn').bind('click', function() {
        //     $('#aplicarPrefRecep').addClass('active')
        // });
        // $('.close-popup').bind('click', function() {
        //     $('#aplicarPrefRecep').removeClass('active')
        // });
        // $('.next-btn-2').bind('click', function() {
        //     $('#aplicarPrefFrec').addClass('active')
        // });
        // $('.close-popup').bind('click', function() {
        //     $('#aplicarPrefFrec').removeClass('active')
        // });
    });

    $(document).ready(function(){
        $('#mailtrain-next-1').on('click',function(){
			var name = $('#mailtrain_name').val();
			var email = $('#mailtrain_email').val();

			if(name !== '' && email !== '') {
				$('#mailtrain_name').removeClass('border-danger');
				$('#mailtrain_email').removeClass('border-danger');
				if($('#user-data').is(':visible')){
					$('#user-data').slideUp();
                    $('#separator-1').hide();
				}
				$('#name-user').html(name);
                $('#msg-ok').html();
				$('#lists').slideDown();
			} else {
				$('#mailtrain_name').addClass('border-danger');
				$('#mailtrain_email').addClass('border-danger');
                $('#msg-ok').html('<div class="text-center alert alert-danger mt-3">El nombre y el email son obligatorios</div>');
			}
		});

        $('#prev-button').on('click',function(){
			if($('#user-data').not(':visible')){
				$('#user-data').slideDown();
			}
			$('#lists').slideUp();
		});
    });
})(jQuery);
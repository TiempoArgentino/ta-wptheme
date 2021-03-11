(function($){
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
      }

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
    });

    $(document).ready(function(){
        $('#mailtrain-next-1').on('click',function(){
			var name = $('#mailtrain_name').val();
			var email = $('#mailtrain_email').val();
            
            if(name === '') {
                $('#msg-ok').html('<div class="text-center alert alert-danger mt-3">Falta el nombre.</div>');
                return;
            }

            if(email === '') {
                $('#msg-ok').html('<div class="text-center alert alert-danger mt-3">Falta el email.</div>');
                return;
            }

            if(!isEmail(email)) {
                $('#msg-ok').html('<div class="text-center alert alert-danger mt-3">El email está mal escrito.</div>');
                return;
            }

			if(name !== '' && email !== '' && isEmail(email)) {
                $('#msg-ok').html('');
				$('#mailtrain_name').removeClass('border-danger');
				$('#mailtrain_email').removeClass('border-danger');
				if($('#user-data').is(':visible')){
					$('#user-data').slideUp();
                    $('#separator-1').hide();
				}
				$('#name-user').html(name);
                
				$('#lists').slideDown();
			} else {
				$('#mailtrain_name').addClass('border-danger');
				$('#mailtrain_email').addClass('border-danger');
                $('#msg-ok').html('<div class="text-center alert alert-danger mt-3">El nombre y el email son obligatorios.</div>');
			}
		});

        $('#prev-button').on('click',function(){
			if($('#user-data').not(':visible')){
				$('#user-data').slideDown();
			}
			$('#lists').slideUp();
		});
    });

    $(document).on('click','#finish-button-1',function(){

        var name = $('#mailtrain_name').val();
        var email = $('#mailtrain_email').val();
        var terms = $('#terms-and-conditions').is(':checked') ? 'yes' : 'no';
        var lists = $('.list-item-select');
        var id = $('#mailtrain_user_id').val();
        var list = [];
        $.each(lists, function() {
            if($(this).is(':checked')) {
                list.push($(this).val());
            }
        });
        list.join(',');


        if(list.length <= 0){
            $('#msg-ok').html('<div class="text-center alert alert-danger mt-3">Debes seleccionar al menos una lista.</div>');
        } else if (!$('#terms-and-conditions').prop('checked')) {
            $('#msg-ok').html('<div class="text-center alert alert-danger mt-3">Debes aceptar los terminos y condiciones.</div>');
        } else {
            $('#msg-ok').html('');
            $.ajax({
                    type: 'post',
                    url: ajax_mailtrain.url,
                    data: {
                        action: ajax_mailtrain.action,
                        nonce: ajax_mailtrain.nonce,
                        name: name,
                        email: email,
                        lists: list,
                        terms: terms,
                        id: id
                    },
                    success: function(response){
                        console.log(response)
                        if(response === 'ok') {
                            $('#msg-ok').html('');
                            $('#thanks-newsletter').slideDown();
                            $('#lists').slideUp();
                            $('#mailtrain_name').val('');
                            $('#mailtrain_email').val('');
                            if($('#terms-and-conditions').is(':checked')){
                                $('#terms-and-conditions').prop('checked',false);
                            }
                        } else {
                            $('#msg-ok').html(response);
                        }
                       
                    },
                    error: function(response) {
                        console.log(response);
                    }
            });
        }
    });
})(jQuery);
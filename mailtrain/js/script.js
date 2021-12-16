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
					$('#user-data').slideUp(400, function(){
                        $('#lists').slideDown();
                        $('#name-user').html(name);
                        $('#separator-1').hide();
                    });
				}
			} else {
				$('#mailtrain_name').addClass('border-danger');
				$('#mailtrain_email').addClass('border-danger');
                $('#msg-ok').html('<div class="text-center alert alert-danger mt-3">El nombre y el email son obligatorios.</div>');
			}
		});

        $('#prev-button-1').on('click',function(){
			if($('#user-data').not(':visible')){
                $('#lists').slideUp(400,function(){
                    $('#user-data').slideDown();
                });
			}
		});
    });

    $(document).on('click','#finish-button-1',function(){

        var name = $('#mailtrain_name').val();
        var email = $('#mailtrain_email').val();
        var terms = $('#terms-and-conditions').is(':checked') ? 'yes' : 'no';
        var lists = $('.list-item-select');
        var listId = $('.list-id');
        var id = $('#mailtrain_user_id').val();
        var list = [];

        
        $.each(lists, function() {
            if($(this).is(':checked')) {
                list.push($(this).val());
            }
        });

        var ids = [];
        $.each(lists, function() {
            if($(this).is(':checked')) {
                ids.push($(this).attr('data-listId'))
            }
        });
        
        list.join(',');

        ids.join(',');

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
                        _ajax_nonce: ajax_mailtrain._ajax_nonce,
                        name: name,
                        email: email,
                        lists: list,
                        terms: terms,
                        id: id,
                        ids:ids
                    },
                    success: function(response){
                        console.log(response) //response
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
    $(document).on('click','#button-ma-widget-front', function(){
        $('#sobre').hide();
    });
})(jQuery);
( function( $ ) {

	(function(old) {
	  $.fn.attr = function() {//Gets all the attributes of an element ex: var $div = $("<div data-a='1' id='b'>"); $div.attr() ---> { "data-a": "1", "id": "b" }
		if(arguments.length === 0) {
			if(this.length === 0) {
				return null;
			}

			var obj = {};
			$.each(this[0].attributes, function() {
				if(this.specified) {
					obj[this.name] = this.value;
				}
			});
			return obj;
		}

		return old.apply(this, arguments);
	  };
	})($.fn.attr);

	function change_control_label( control, value ){
		jQuery(wp.customize.control( control ).container[0]).find(".customize-control-title").html( value );
	}

	function find_input_control_attributes ( $control ) {
		return $(wp.customize.control( $control ).container["0"]).find("input").attr();
	}

    wp.customizerCtrlEditor = {

        init: function() {

            $(window).on('load',function(){

                $('textarea.wp-editor-area').each(function(){
                    var tArea = $(this),
                        id = tArea.attr('id'),
                        editor = tinyMCE.get(id),
                        setChange,
                        content;

                    if(editor){
                        editor.onChange.add(function (ed, e) {
                            ed.save();
                            content = editor.getContent();
                            clearTimeout(setChange);
                            setChange = setTimeout(function(){
                                tArea.val(content).trigger('change');
                            },500);
                        });
                    }

                    tArea.css({
                        visibility: 'visible'
                    }).on('keyup', function(){
                        content = tArea.val();
                        clearTimeout(setChange);
                        setChange = setTimeout(function(){
                            content.trigger('change');
                        },500);
                    });
                });
            });
        }

    };

    wp.customizerCtrlEditor.init();

    wp.customizerInputsCollapsible= {

        init: function() {

            $(window).on('load',function(){
				$(document).on("click",".title-holder", function(){
					var $settings = $(this).siblings(".input-container-control");

					if (!$settings.length)
						$settings = $(this).siblings(".collapsible-body");

					var $arrow = $(this).children(".customize-control-arrow i:not(.delete-item)");
					if ( !$settings.hasClass("animating") ){
						$settings.addClass("animating");

						if ( $settings.css("display") == "none" ){
							$settings.slideDown();
							$arrow.css('transform','rotate(180deg)');
						}
						else{
							$settings.slideUp();
							$arrow.removeClass('rotate');
							$arrow.css('transform','rotate(0deg)');
						}

						$settings.removeClass("animating");
					}
				});
            });
        }

    };
	wp.customizerInputsCollapsible.init();

	$(document).on("click",".collapsible-title", function(event){
		console.log(event);
		event.stopPropagation();
		var $settings = $(this).next(".collapsible-body");
		var $arrow = $(this).find(".collapsible-arrow");
		var _this = this;
		if ( !$settings.hasClass("animating") ){
			$settings.addClass("animating");

			if ( $settings.css("display") == "none" ){
				$settings.stop().slideDown();
				$(_this).addClass("collapsible-open");
				$arrow.css('transform','rotate(180deg)');
			}
			else{
				$settings.stop().slideUp(function(){
					$(_this).removeClass("collapsible-open");
				});
				$arrow.removeClass('rotate');
				$arrow.css('transform','rotate(0deg)');
			}

			$settings.removeClass("animating");
		}
	});

	$(document).ready(function(){
		$(".collapsible-title.collapsible-open").click();
	});

} )( jQuery );

/*Function for the extended control, it hides/shows the input controls dependencies*/
function toggle_dependencies(controlID, inputID, dependencies){
	var masterControl = wp.customize.control(controlID);

	var dependentsControls = dependencies;

	var value = masterControl.setting();

	if ( dependentsControls.reverse )
		value = !value;

	if ( dependentsControls.controls ){
		dependentsControls.controls.forEach(function(control){
			var currentControl = wp.customize.control( control );
			if ( currentControl )
				currentControl.toggle(value);
		});
	}
	else if ( dependentsControls.hide_all ){
		//console.log(wp.customize.section(masterControl.section()).controls())
		wp.customize.section(masterControl.section()).controls().forEach(function(control){
			console.log(wp.customize.control( control.id ));
			if ( control.id != controlID )
				wp.customize.control( control.id ).toggle(value);
		});
	}
}

// =============================================================================
// CONTROL PANEL
// =============================================================================
function closeControlPanel( $controlPanel ){
	$controlPanel.css("height", "0");
	$controlPanel.css("padding-bottom", "0");
}

$(document).on( "click", ".rb-control-panel .rb-control-panel-close-button", function(event){
	closeControlPanel($(this).closest(".rb-control-panel"));
});

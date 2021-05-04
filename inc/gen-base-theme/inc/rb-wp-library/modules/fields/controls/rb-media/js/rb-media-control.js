(function($){

    function getAttachmentValue($control, attachment){
        if($control.attr('data-value-type') == 'id')
            return attachment.id;
        return attachment.url;
    }

    function getMimeType($control){
        return JSON.parse($control.attr('data-mime'));
    }

    $(document).ready(function(){
        $(document).on('click', '.input-wp-media-image-holder', function(e) {
            e.stopPropagation();
            e.preventDefault();
            if(this.hasAttribute("media-open"))
                return;
            var $button = $(this);
			$button.attr('media-open', '');
            // console.log( $(this));
            var $control = $(this).closest(".inputs-generator-inputs-holder");
            var $input_field = $(this).find("input");
            var $image_holder = $(this).find(".input-image-src");
            const mimeTypes = getMimeType($control);
            const config = {
                title: 'Add Image',
                button: {
                    text: 'Add Image',
                },
                multiple: false
            };

            if(mimeTypes){
                config.library = {
                    type: mimeTypes
                };
            }

            var custom_uploader = wp.media.frames.file_frame = wp.media(config);

            custom_uploader.on('open', function() {
                if($control.attr('data-value-type') == 'id' && $input_field.val()){
                    // Used for defining the image selections in the media library.
                    var selectionAPI = custom_uploader.state().get( 'selection' );
                    var attachment = wp.media.attachment( $input_field.val() );
                    selectionAPI.add( attachment ? [ attachment ] : []);
                }
            });

            custom_uploader.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                if(!mimeTypes || mimeTypes.find( mime => mime == attachment.mime )){
                    const storeValue = getAttachmentValue($control, attachment);
                    // console.log(attachment.url);
                    $input_field.val(storeValue).trigger('input');
                    //updateValue( $controlPanel );
                    $image_holder.attr('src', attachment.url );
                }
                $button.removeAttr('media-open');
            });

            custom_uploader.on('close', function(){
                $button.removeAttr('media-open');
                custom_uploader.detach();
            });

            custom_uploader.open();
        });

        $(document).on('click', '.inputs-generator-inputs-holder .remove-image-button i', function( event ){
            event.stopPropagation();
            emptyImageInput( $(this).closest('.inputs-generator-inputs-holder') );
        });

        function emptyImageInput( $inputHolder ){
    		var $image = $inputHolder.find('.input-image-src');
    		var $input = $inputHolder.find('input');
    		$image.attr('src','');
    		$input.val('').trigger('input');
    		// console.log($controlPanel);
    		//updateValue( $controlPanel );
    	}
    });

})(jQuery);

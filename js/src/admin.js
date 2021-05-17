jQuery(function($) {

    function getPanelMetaKey($panel){
        return $panel.data('metakey');
    }

    function getPanel($elem){
        return $elem.closest('.ta-articles-images-controls');
    }

    function getValue($panel){
        return $panel.data('metavalue');
    }

    function getPostID($panel){
        return $panel.data('id');
    }

    function getPostType($panel){
        return $panel.data('type');
    }

    function setImage({ $panel, imageURL }){
        if( !imageURL )
            $panel.addClass('empty');
        else
            $panel.removeClass('empty');

        $panel.find('.image-box .bkg').css({
            backgroundImage: `url("${imageURL}")`,
        });
    }

    function updatePostMeta({ postID, attachmentID, metaKey }){
        return wp.apiRequest({
            data: {
                meta: metaKey,
                value: attachmentID,
                postID: postID,
            },
            method: 'POST',
            path: `/ta/v1/post/meta/`,
            parse: false,
        });
    }

    function isLoading($panel){
        return $panel.hasClass('loading');
    }

    function setLoadingStatus($panel){
        $panel.addClass('loading');
    }

    function endLoadingStatus($panel){
        $panel.removeClass('loading');
    }

    $('body').on('click', '.ta-articles-images-controls:not(.loading) .content', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var $button = $(this);
        var $panel = getPanel($button);

        if(isLoading($panel))
            return;
        setLoadingStatus($panel);

        const value = getValue($panel);

        var custom_uploader = wp.media({
            title: 'Establecer Imagen',
            library: {
                type: 'image'
            },
            button: {
                text: 'Seleccionar Imagen'
            },
            selected: value ? [value] : null,
        });

        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            // $(button).html('<img src="' + attachment.url + '" />').next().val(attachment.id).parent().next().show();

            updatePostMeta({
                postID: getPostID($panel),
                metaKey: getPanelMetaKey($panel),
                attachmentID: attachment.id,
            })
            .then( (data) => {
                setImage({
                    $panel,
                    imageURL: attachment.url,
                });
                endLoadingStatus($panel);
            })
            .catch( (response) => {
                alert(`ERROR: ${response.responseJSON.message}`);
                endLoadingStatus($panel);
            })
        });

        custom_uploader.on('open', function(){
            setTimeout( () => {
                if(value){
                    var selection = custom_uploader.state().get('selection');
                    const attachment = wp.media.attachment(value);
                    if(attachment){
                        attachment.fetch();
                        selection.add([attachment]);
                    }
                }
            }, 0);
        });

        custom_uploader.on('close', function(){
            custom_uploader.detach();
        });

        custom_uploader.open();
    });

    $('body').on('click', '.ta-articles-images-controls:not(.loading) .content .remove-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        // $(this).hide().prev().val('-1').prev().html('Set featured Image');
        var $panel = getPanel($(this));
        if(isLoading($panel))
            return;

        setLoadingStatus($panel);
        updatePostMeta({
            postID: getPostID($panel),
            metaKey: getPanelMetaKey($panel),
            attachmentID: null,
        })
        .then( (data) => {
            setImage({
                $panel,
                imageURL: '',
            });
            endLoadingStatus($panel);
        })
        .catch( (response) => {
            alert(`ERROR: ${response.responseJSON.message}`);
            endLoadingStatus($panel);
        })
    });

    $(document).ready(function(){
        var link = $('li#wp-admin-bar-new-content a.ab-item:first-child').attr('href');
        $('li#wp-admin-bar-new-content a.ab-item:first-child').attr('href', link + '?post_type=ta_article');
      });
    // var $wp_inline_edit = inlineEditPost.edit;
    // inlineEditPost.edit = function(id) {
    //     $wp_inline_edit.apply(this, arguments);
    //     var $post_id = 0;
    //     if (typeof(id) == 'object') {
    //         $post_id = parseInt(this.getId(id));
    //     }
    //
    //     if ($post_id > 0) {
    //         var $edit_row = $('#edit-' + $post_id),
    //             $post_row = $('#post-' + $post_id),
    //             $featured_image = $('.column-featured_image', $post_row).html(),
    //             $featured_image_id = $('.column-featured_image', $post_row).find('img').attr('data-id');
    //
    //
    //         if ($featured_image_id != -1) {
    //
    //             $(':input[name="_thumbnail_id"]', $edit_row).val($featured_image_id); // ID
    //             $('.misha_upload_featured_image', $edit_row).html($featured_image); // image HTML
    //             $('.misha_remove_featured_image', $edit_row).show(); // the remove link
    //
    //         }
    //     }
    // }
});

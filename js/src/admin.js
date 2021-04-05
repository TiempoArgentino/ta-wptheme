jQuery(function($) {

    function getPanelMetaKey($panel){
        return $panel.data('metakey');
    }

    function getPanel($elem){
        return $elem.closest('.ta-articles-images-controls');
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

    function updatePostAttachment({ postID, attachmentID }){
        wp.apiRequest({
            data: {
                meta: 'ta_article_thumbnail_alt',
                value: attachmentID,
                article_id: postID,
            },
            method: 'POST',
            path: `/ta/v1/article/meta/`,
            parse: false,
        })
            .then((data) => {
                console.log(data);
            });
    }

    function updatePostMeta({ postID, attachmentID, metaKey }){
        wp.apiRequest({
            data: {
                meta: metaKey,
                value: attachmentID,
                article_id: postID,
            },
            method: 'POST',
            path: `/ta/v1/article/meta/`,
            parse: false,
        })
            .then((data) => {
                console.log(data);
            });
    }

    $('body').on('click', '.ta-articles-images-controls .content', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var $button = $(this);
        var $panel = getPanel($button);

        var custom_uploader = wp.media({
            title: 'Establecer Imagen',
            library: {
                type: 'image'
            },
            button: {
                text: 'Seleccionar Imagen'
            },
        }).on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            // $(button).html('<img src="' + attachment.url + '" />').next().val(attachment.id).parent().next().show();
            setImage({
                $panel,
                imageURL: attachment.url,
            });
            updatePostMeta({
                postID: getPostID($panel),
                metaKey: getPanelMetaKey($panel),
                attachmentID: attachment.id,
            });
        }).open();
    });

    $('body').on('click', '.ta-articles-images-controls .content .remove-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        // $(this).hide().prev().val('-1').prev().html('Set featured Image');
        var $panel = getPanel($(this));
        setImage({
            $panel,
            imageURL: '',
        });
        updatePostMeta({
            postID: getPostID($panel),
            metaKey: getPanelMetaKey($panel),
            attachmentID: null,
        });
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

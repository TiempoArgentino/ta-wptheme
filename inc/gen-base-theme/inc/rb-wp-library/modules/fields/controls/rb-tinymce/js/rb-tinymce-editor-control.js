(function($){
    var tinymceSettings = {
		quicktags: {
			buttons:"strong,em,link,ul,ol,li,aligncenter"
		},
		tinymce: {
            height: '200',
			branding:false,
			browser_spellcheck:true,
			cache_suffix:"wp-mce-4607-20180123",
			convert_urls:false,
			elementpath:false,
			end_container_on_empty_block:true,
			entities:"38,amp,60,lt,62,gt",
			entity_encoding:"raw",
			fix_list_elements:true,
            hidden_input: true,
			//formats:{alignleft: Array(2), aligncenter: Array(2), alignright: Array(2), strikethrough: {…}},
			indent:true,
			keep_styles:false,
			language:"es",
			menubar:false,
			plugins:"fullscreen,charmap,colorpicker,hr,lists,paste,tabfocus,textcolor,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wptextpattern",
			preview_styles:"font-family font-size font-weight font-style text-decoration text-transform",
			relative_urls:false,
			remove_script_host:false,
			resize:"vertical",
			skin:"lightgray",
			theme:"modern",
			toolbar1:"fullscreen,bold,italic,underline,strikethrough,alignleft,aligncenter,justifyleft,alignright,alignjustify,justifycenter,justifyright,justifyfull,bullist,numlist,outdent,indent,cut,copy,paste,undo,redo,link,unlink,image,cleanup,help,code,hr,removeformat,formatselect,fontselect,fontsizeselect,styleselect,sub,sup,forecolor,backcolor,forecolorpicker,backcolorpicker,charmap,visualaid,anchor,newdocument,blockquote,separator",
			wp_keep_scroll_position:false,
			wp_lang_attr:"es-ES",
			wp_shortcut_labels:{
				'Align center':"accessC",
				'Align left':"accessL",
				'Align right':"accessR",
				'Blockquote':"accessQ",
				'Bold':"metaB",
				'Bullet list':"accessU",
				'Code':"accessX",
				'Copy':"metaC",
				'Cut':"metaX",
				'Distraction-free writing mode':"accessW",
				'Heading 1':"access1",
				'Heading 2':"access2",
				'Heading 3':"access3",
				'Heading 4':"access4",
				'Heading 5':"access5",
				'Heading 6':"access6",
				'Insert Page Break tag':"accessP",
				'Insert Read More tag':"accessT",
				'Insert/edit image':"accessM",
				'Italic':"metaI",
				'Justify':"accessJ",
				'Keyboard Shortcuts':"accessH",
				'Numbered list':"accessO",
				'Paragraph':"access7",
				'Paste':"metaV",
				'Redo':"metaY",
				'Remove link':"accessS",
				'Select all':"metaA",
				'Strikethrough':"accessD",
				'Toolbar Toggle':"accessZ",
				'Underline':"metaU",
				'Undo':"metaZ"
			},
			wpautop:false,
			wpeditimage_html5_captions:true
		}
	};

    //Checks if the editor is on wp.editor or wp.oldEditor and returns the correct one
    function getEditorAPI(){
        return wp.editor.initialize ? wp.editor : wp.oldEditor;
    }

    // =============================================================================
    //
    // =============================================================================
    var rbTinymceEditor = {
        removePlaceholderValueLink: function($panel){
            $panel.find('[placeholder-value]').removeAttr('rb-control-value').removeAttr('name');
        },
        getControlValue: function($panel){
            //console.log($panel);
            return $panel.find('[placeholder-value]').val();
        },
        getPanelEditorID: function($panel){
            return $panel.find('.rb-tinymce-editor').attr('id');
        },
        getEditorHiddenInput: function(tinymce){
            return $(tinymce.editorContainer).closest('.wp-editor-container').find(`input[name=${tinymce.id}]`);
        },
        openPanelMediaUploader: function($panel){
            var tinymce = tinyMCE.get(this.getPanelEditorID($panel));
            if( !tinymce )
                return;

            var custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Add Image',
                button: {
                    text: 'Add Image',
                },
                multiple: 'add',
            });
            custom_uploader.on('select', function() {
                var imagesArr = custom_uploader.state().get('selection').models;
                var finalHTML = "";
                imagesArr.forEach( function( image, index ){
                    finalHTML += '<img src="'+ image.changed.url +'"/>';
                });
                tinymce.insertContent(finalHTML);
            });
            custom_uploader.open();
        },
        openEditor: function($panel){
            $panel.find('.tinymce-editor-container').slideDown();
        },
        removeEditor: function(editorID){
            var editor = tinyMCE.get(editorID);
            if(editor){
                let editorAPI = getEditorAPI();
                editorAPI.remove(editorID);
                editor.destroy();
            }
        },
        loadEditor: function($panel){
            var editorID = this.getPanelEditorID($panel);
            var controlContent = this.getControlValue($panel);
            let editorAPI = getEditorAPI();

            this.openEditor($panel);
			editorAPI.initialize( editorID, tinymceSettings);
            var tinymce = tinyMCE.get(editorID);
            var rbEditorManager = this;

            if(tinymce){
                tinymce.on('init', function(args) {
                    //Add rb attribute to link to controller
                    rbEditorManager.getEditorHiddenInput(tinymce).attr('rb-control-value', '');
                    //console.log(tinymce, controlContent);
                    tinymce.setContent( controlContent );
                });
                tinymce.on("change KeyDown KeyUp", function(data) {
                    tinymce.save();
                    rbEditorManager.getEditorHiddenInput(tinymce).trigger('change');
                });
                rbEditorManager.removePlaceholderValueLink($panel);
                $panel.addClass('editor-open');
            }
        },
    };

    function openPanelTinyMCE($panel){
        rbTinymceEditor.removeEditor( rbTinymceEditor.getPanelEditorID($panel) );
        rbTinymceEditor.loadEditor($panel);
    }

    $(document).on('click', '.rb-tinymce-control .editor-open-button', function(){
        $panel = $(this).closest('.rb-tinymce-control');
        openPanelTinyMCE($panel);
    });

    $(document).on('click', '.rb-tinymce-control .media-button', function(){
        $panel = $(this).closest('.rb-tinymce-control');
        rbTinymceEditor.openPanelMediaUploader($panel);
    });
    //
    // $(document).ready(function(){
    //     setTimeout(function(){
    //         $('.rb-tinymce-control').each(function(){
    //             openPanelTinyMCE($(this));
    //         });
    //     }, 0);
    // });
    //
    // document.addEventListener('rbItemCreation', function(event){
    //     event.detail.$controls.find('.rb-tinymce-control').each(function(){
    //         openPanelTinyMCE($(this));
    //     });
    // });
    //
    // document.addEventListener('rbItemRemoval', function(event){
    //     event.detail.$controls.find('.rb-tinymce-control').each(function(){
    //         rbTinymceEditor.removeEditor( rbTinymceEditor.getPanelEditorID($(this)) );
    //     });
    // });

    // Toggle editors when tinymce gets defined. removed for compability issues with other plugins
    // var tinymceCheckInterval = setInterval(function(){
    //     if(typeof tinyMCE !== 'undefined'){
    //         $('.rb-tinymce-control').each(function(){
    //             openPanelTinyMCE($(this));
    //         });
    //         clearInterval(tinymceCheckInterval);
    //     }
    // }, 10);

})(jQuery);

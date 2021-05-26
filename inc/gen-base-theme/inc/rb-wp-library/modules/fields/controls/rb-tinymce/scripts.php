<?php

//Tinymce Editor Control
wp_enqueue_editor();
wp_enqueue_style( 'rb-tinymce-editor-control', rb_get_file_url(__DIR__) . '/css/rb-tinymce-editor-control.css' );
//Enqueing the script directly, because there is no hook for when the tinymce js
//has been loaded
wp_enqueue_script( 'rb-tinymce-editor-control', rb_get_file_url(__DIR__) . '/js/rb-tinymce-editor-control.js', array('jquery'), true );

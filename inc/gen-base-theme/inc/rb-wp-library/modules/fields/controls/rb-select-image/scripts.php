<?php
//Image Selection control
wp_enqueue_style( 'rb-image-selection-control', rb_get_file_url(__DIR__) . '/css/rb-image-selection-control.css' );
wp_enqueue_script( 'rb-select-image', rb_get_file_url(__DIR__) . '/js/rb-select-image-control.js', array('jquery'), true );

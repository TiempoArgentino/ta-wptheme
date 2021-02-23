<?php

//Double list control
wp_enqueue_style( 'rb-attachment-focus-control', rb_get_file_url(__DIR__) . '/css/rb-attachment-focus-control.css' );
wp_enqueue_script( 'rb-attachment-focus-control', rb_get_file_url(__DIR__) . '/js/rb-attachment-focus-control.js', array('jquery'), true );

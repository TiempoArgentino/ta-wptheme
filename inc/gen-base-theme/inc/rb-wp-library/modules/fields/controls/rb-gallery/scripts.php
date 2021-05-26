<?php

//Gallery control
wp_enqueue_style( 'rb-gallery-control', rb_get_file_url(__DIR__) . '/css/rb-gallery-control.css' );
wp_enqueue_script( 'rb-gallery-control', rb_get_file_url(__DIR__) . '/js/rb-gallery-control.js', array('jquery'), true );

<?php

// Add the color picker css file
wp_enqueue_style( 'wp-color-picker' );
// Include our custom jQuery file with WordPress Color Picker dependency
wp_enqueue_script( 'rb-color-picker', rb_get_file_url(__DIR__) . '/js/rb-color-picker-control.js', array( 'wp-color-picker' ), false, true );
wp_enqueue_script( 'wp-color-picker-alpha', rb_get_file_url(__DIR__) . '/js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), false, true );

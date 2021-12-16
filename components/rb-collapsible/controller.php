<?php
wp_enqueue_script( 'rb-collapsible', rb_get_theme_file_url( dirname(__FILE__) ) . 'js/rb-collapsible.js', array('jquery'), true );
wp_enqueue_style( 'rb-collapsible', rb_get_theme_file_url( dirname(__FILE__) ) . 'css/rb-collapsible.css' );

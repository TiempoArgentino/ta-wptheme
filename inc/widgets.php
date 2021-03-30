<?php

class Widgets_Theme_TA
{
    public function __construct()
    {
        add_action( 'widgets_init', [$this,'over_header_note'] );
        add_action( 'widgets_init', [$this,'over_single_note'] );
        add_action( 'widgets_init', [$this,'side_single_note'] );
    }

    public function over_header_note() {
        register_sidebar( array(
            'name'          => __( 'Sobre header en nota', 'gen-theme-base' ),
            'id'            => 'over-header-note',
            'before_widget' => '',
            'after_widget'  => '',
        ) );
    }

    public function over_single_note() {
        register_sidebar( array(
            'name'          => __( 'Sobre la nota', 'gen-theme-base' ),
            'id'            => 'over-single-note',
            'before_widget' => '',
            'after_widget'  => '',
        ) );
    }

    public function side_single_note() {
        register_sidebar( array(
            'name'          => __( 'Sidebar nota', 'gen-theme-base' ),
            'id'            => 'side-single-note',
            'before_widget' => '',
            'after_widget'  => '',
        ) );
    }
   
}

function widgets_ta()
{
    return new Widgets_Theme_TA();
}

widgets_ta();
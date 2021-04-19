<?php

class Widgets_Theme_TA
{
    public function __construct()
    {

        add_action('widgets_init', [$this,'home_desktop_widgets']);

        add_action('widgets_init', [$this, 'note_desktop_widgets']);

        add_action('widgets_init', [$this,'middle_single']);

        add_filter('the_content', [$this,'insert_custom_content']);

        add_filter('the_content', [$this,'insert_custom_content_2']);

        add_action('widgets_init', [$this,'home_mobile']);

        add_action('widgets_init', [$this, 'note_mobile']);

        
    }

    public function home_desktop_widgets()
    {
        $widgets = ['home_desk_1' => __('Home Desktop 1', 'gen-theme-base'),'home_desk_2' => __('Home Desktop 2', 'gen-theme-base')];

        foreach($widgets as $key => $val) {
            register_sidebar(array(
                'name'          => $val,
                'id'            => $key,
                'before_widget' => '',
                'after_widget'  => '',
            ));
        }
    }

    public function note_desktop_widgets()
    {
        $widgets = [
            'over-header-note' => __('Sobre header en nota', 'gen-theme-base'),
            'over-single-note' => __('Sobre la nota', 'gen-theme-base'),
            'side-single-note' => __('Sidebar nota', 'gen-theme-base'),
            'down-single-note' => __('Abajo nota', 'gen-theme-base'),
            'down-comments-note' => __('Abajo comentarios', 'gen-theme-base'),
            'side-comments-note' => __('Lado comentarios', 'gen-theme-base'),
        ];

        foreach($widgets as $key => $val) {
            register_sidebar(array(
                'name'          => $val,
                'id'            => $key,
                'before_widget' => '',
                'after_widget'  => '',
            ));
        }
    }

    public function home_mobile()
    {
        $widgets = [
            'home_mob_1' => __('Header Mobile 1', 'gen-theme-base'),
            'home_mob_2' => __('Home Mobile 1', 'gen-theme-base'),
        ];

        foreach($widgets as $key => $val) {
            register_sidebar(array(
                'name'          => $val,
                'id'            => $key,
                'before_widget' => '',
                'after_widget'  => '',
            ));
        }
    }

    public function note_mobile()
    {
        $widgets = [
            'note_mob_1' => __('Note Header Mobile', 'gen-theme-base'),
            'note_mob_2' => __('Note BoxMobile 3', 'gen-theme-base'),
        ];

        foreach($widgets as $key => $val) {
            register_sidebar(array(
                'name'          => $val,
                'id'            => $key,
                'before_widget' => '',
                'after_widget'  => '',
            ));
        }
    }


    public function middle_single()
    {
        register_sidebar(array(
            'name'          => __('Nota medio (Desk / Mob)', 'gen-theme-base'),
            'id'            => 'middle-single-note',
            'before_widget' => '<div class="col-7 mx-auto mt-5 mb-5">',
            'after_widget'  => '</div>',
        ));
    }

    public function middle_single_mob()
    {
        register_sidebar(array(
            'name'          => __('Nota medio (Mob)', 'gen-theme-base'),
            'id'            => 'middle-single-note-mobile',
            'before_widget' => '<div class="col-7 mx-auto mt-5 mb-5 d-sm-none d-md-block">',
            'after_widget'  => '</div>',
        ));
    }
    /**
     * Middle note
     */
    public function insert_middle()
    {
        if (is_active_sidebar('middle-single-note')):
            return dynamic_sidebar('middle-single-note');
        endif;
    }

    public function insert_middle_mobile()
    {
        if (is_active_sidebar('middle-single-note-mobile')):
            return dynamic_sidebar('middle-single-note-mobile');
        endif;
    }

    public function insert_custom_content($content) {
        
        ob_start();
        $this->insert_middle();
        $widget_area_html = ob_get_clean();

        if (is_single() && ! is_admin()) {
            return $this->insert_after_paragraph($widget_area_html, 2, $content);
        }
    
        return $content;
    }

    public function insert_custom_content_2($content) {
        
        ob_start();
        $this->insert_middle_mobile();
        $widget_area_html = ob_get_clean();

        if (is_single() && ! is_admin()) {
            return $this->insert_after_paragraph($widget_area_html, 4, $content);
        }
    
        return $content;
    }
    
    
    public function insert_after_paragraph($insertion, $paragraph_id, $content) {
        $closing_p = '</p>';
        $paragraphs = explode($closing_p, $content);
    
        foreach ($paragraphs as $index => $paragraph) {
            if (trim($paragraph)) {
                $paragraphs[$index] .= $closing_p;
            }
    
            if ($paragraph_id == $index + 1) {
                $paragraphs[$index] .= $insertion;
            }
        }
    
        return implode('', $paragraphs);
    }
     /**
     * Middle note
     */
}

function widgets_ta()
{
    return new Widgets_Theme_TA();
}

widgets_ta();

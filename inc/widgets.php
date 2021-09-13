<?php

class Widgets_Theme_TA
{
    public function __construct()
    {

        add_action('widgets_init', [$this, 'home_desktop_widgets']);

        add_action('widgets_init', [$this, 'note_desktop_widgets']);

        add_action('widgets_init', [$this, 'middle_single']);

        add_action('widgets_init', [$this, 'middle_single_2']);

        add_action('widgets_init', [$this, 'middle_mobile']);

        add_action('widgets_init', [$this, 'middle_mobile_amp']);

        add_action('widgets_init', [$this, 'insert_middle_mob']);

        add_filter('the_content', [$this, 'insert_custom_content']);

        add_filter('the_content', [$this, 'insert_custom_content_amp_1']);

        add_filter('the_content', [$this, 'insert_custom_content_amp_2']);

        add_filter('the_content', [$this, 'insert_custom_content_2']);

        add_filter('the_content', [$this, 'insert_custom_content_3']);

        add_action('widgets_init', [$this, 'footer_fixed_mobile']);

        add_action('widgets_init', [$this, 'footer_fixed']);

        add_action('widgets_init', [$this, 'pop_desktop']);

        add_action('widgets_init', [$this, 'pop_mobile']);

        add_action('widgets_init', [$this, 'vslider_mobile']);

        add_action('widgets_init', [$this, 'vslider_desktop']);

        add_action('widgets_init', [$this, 'home_mobile']);

        add_action('widgets_init', [$this, 'note_mobile']);

        add_action('widgets_init', [$this, 'seccion_desktop_widgets']);

        add_action('widgets_init', [$this, 'micrositio_widgets']);

        add_action('widgets_init', [$this, 'blockes_widgets']);
    }

    public function home_desktop_widgets()
    {
        $widgets = ['home_desk_1' => __('Home Desktop 1', 'gen-base-theme'), 'home_desk_2' => __('Home Desktop 2', 'gen-base-theme')];

        foreach ($widgets as $key => $val) {
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
            'over-header-note' => __('Sobre header en nota', 'gen-base-theme'),
            'over-single-note' => __('Sobre la nota', 'gen-base-theme'),
            'side-single-note' => __('Sidebar nota', 'gen-base-theme'),
            'down-single-note' => __('Abajo nota', 'gen-base-theme'),
            'down-comments-note' => __('Abajo comentarios', 'gen-base-theme'),
            'side-comments-note' => __('Lado comentarios', 'gen-base-theme'),
        ];

        foreach ($widgets as $key => $val) {
            register_sidebar(array(
                'name'          => $val,
                'id'            => $key,
                'before_widget' => '',
                'after_widget'  => '',
            ));
        }
    }

    public function footer_fixed_mobile()
    {

        register_sidebar(array(
            'name'          => __('Fija Abajo Mobile', 'gen-base-theme'),
            'id'            => 'footer_fixed_mobile',
            'before_widget' => '<div id="sticky-abajo" class="d-block d-sm-none d-md-none d-lg-none position-fixed text-center">
            <div class="sticky-bajo mobile-fixed">
                <span class="cerrar-pop-abajo mobile-pop-close">
                    <img src="'.get_stylesheet_directory_uri().'/assets/img/times-circle-regular.svg" />
                </span>',
            'after_widget'  => ' </div>
            </div>',
        ));
    }

    public function footer_fixed()
    {
        register_sidebar(array(
            'name'          => __('Fija Abajo Desktop', 'gen-base-theme'),
            'id'            => 'footer_fixed',
            'before_widget' => '<div id="sticky-abajo" class="d-none d-sm-none d-md-block d-lg-block position-fixed text-center">
            <div class="sticky-bajo">
                <span class="cerrar-pop-abajo">
                    <img src="'.get_stylesheet_directory_uri().'/assets/img/times-circle-regular.svg" />
                </span>',
            'after_widget'  => '</div>
            </div>',
        ));
    }

    public function vslider_mobile()
    {
        register_sidebar(array(
            'name'          => __('VSlider Mobile', 'gen-base-theme'),
            'id'            => 'vslider_mobile',
            'before_widget' => '<div id="popup-avis" class="d-block d-sm-none d-md-none d-lg-none position-fixed">
            <div class="popup popup-mobile">
                <span class="cerrar-pop pop-mobile-close">
                    <img src="'.get_stylesheet_directory_uri().'/assets/img/times-circle-regular.svg" />
                </span>
                ',
            'after_widget'  => ' </div>
            </div>',
        ));
    }

    public function vslider_desktop()
    {
        register_sidebar(array(
            'name'          => __('VSlider Dektop', 'gen-base-theme'),
            'id'            => 'vslider_desktop',
            'before_widget' => ' <div id="vslider" class="d-none d-sm-none d-md-block d-lg-block position-fixed text-center">
            <div class="video-bajo">
                <span class="cerrar-vslider-desktop">
                    <img src="'.get_stylesheet_directory_uri().'/assets/img/times-circle-regular.svg" />
                </span>',
            'after_widget'  => '</div>
            </div>',
        ));
    }

    public function pop_desktop()
    {
        register_sidebar(array(
            'name'          => __('Popup Home', 'gen-base-theme'),
            'id'            => 'popup',
            'before_widget' => '<div id="popup-avis" class="d-none d-sm-none d-md-block d-lg-block position-fixed">
            <div class="popup">
                <span class="cerrar-pop">
                    <img src="' . get_stylesheet_directory_uri() . '/assets/img/times-circle-regular.svg" />
                </span>',
            'after_widget'  => '</div>
            </div>',
        ));
    }

    public function pop_mobile()
    {
        register_sidebar(array(
            'name'          => __('Popup Mobile Home', 'gen-base-theme'),
            'id'            => 'popup_mobile',
            'before_widget' => '<div id="popup-avis-pop" class="popup-mobile popup d-block d-sm-none d-md-none d-lg-none position-fixed">
            <div class="popup">
                <span class="cerrar-pop cerrar-pop-mobile">
                    <img src="' . get_stylesheet_directory_uri() . '/assets/img/times-circle-regular.svg" />
                </span>',
            'after_widget'  => '</div>
            </div>',
        ));
    }

    public function home_mobile()
    {
        $widgets = [
            'home_mob_2' => __('Home Mobile 1', 'gen-base-theme'),
        ];

        foreach ($widgets as $key => $val) {
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
            'note_mob_1' => __('Note Header Mobile', 'gen-base-theme'),
            'note_mob_2' => __('Note BoxMobile 2', 'gen-base-theme'),
            'note_mob_3' => __('Note BoxMobile 3', 'gen-base-theme'),
           // 'note_mob_4' => __('Note Bajo Newsletter Mobi', 'gen-base-theme'),
           // 'note_mob_5' => __('Note Comentarios Mobi', 'gen-base-theme'),
           // 'note_mob_6' => __('Relacionados Mobi', 'gen-base-theme'),
            'note_mob_7' => __('Abajo de la foto Mobile', 'gen-base-theme')
        ];

        foreach ($widgets as $key => $val) {
            register_sidebar(array(
                'name'          => $val,
                'id'            => $key,
                'before_widget' => '',
                'after_widget'  => '',
            ));
        }
    }

    /**
     * Middle note
     */

    public function middle_single()
    {
        register_sidebar(array(
            'name'          => __('Nota medio 1 (Desk)', 'gen-base-theme'),
            'id'            => 'middle-single-note',
            'before_widget' => '<div class="col-7 mx-auto mt-5 mb-5 d-none d-ms-none d-md-block d-lg-block">',
            'after_widget'  => '</div>',
        ));
    }

    public function middle_single_2()
    {
        register_sidebar(array(
            'name'          => __('Nota medio 2 (Desk)', 'gen-base-theme'),
            'id'            => 'middle-single-note-mobile',
            'before_widget' => '<div class="col-7 mx-auto mt-5 mb-5 d-none d-ms-none d-md-block d-lg-block">',
            'after_widget'  => '</div>',
        ));
    }

    public function middle_mobile()
    {
        $widgets = [
            'note_mob_mid_1' => __('Nota medio mobile 1', 'gen-base-theme'),
          //  'note_mob_mid_2' => __('Nota medio mobile 2', 'gen-base-theme'),
        ];

        foreach ($widgets as $key => $val) {
            register_sidebar(array(
                'name'          => $val,
                'id'            => $key,
                'before_widget' => '<div class="d-block d-sm-none d-md-none d-lg-none mt-3 mb-3 max-auto col-12 text-center">',
                'after_widget'  => '</div>',
            ));
        }
    }

    public function middle_mobile_amp()
    {
        $widgets = [
            'note_mob_mid_1_amp' => __('Note medio mobile 1 AMP', 'gen-base-theme'),
            'note_mob_mid_2_amp' => __('Note medio mobile 2 AMP', 'gen-base-theme'),
            'note_mob_before_related' => __('AMP Arriba de relacionadas', 'gen-base-theme'),
        ];

        foreach ($widgets as $key => $val) {
            register_sidebar(array(
                'name'          => $val,
                'id'            => $key,
                'before_widget' => '',
                'after_widget'  => '',
            ));
        }
    }

    public function insert_middle_amp_1()
    {
        if (is_active_sidebar('note_mob_mid_1_amp')) :
            return dynamic_sidebar('note_mob_mid_1_amp');
        endif;
    }

    public function insert_middle_amp_2()
    {
        if (is_active_sidebar('note_mob_mid_2_amp')) :
            return dynamic_sidebar('note_mob_mid_2_amp');
        endif;
    }

    public function note_mob_before_related()
    {
        if (is_active_sidebar('note_mob_before_related')) :
            $publi = '<div class="publi-amp-before-related">';
            $publi .= dynamic_sidebar('note_mob_before_related');
            $publi .= '</div>';
            return $publi;
        endif;
    }

    public function insert_custom_content_amp_2($content)
    {
        ob_start();
        $this->insert_middle_amp_2();
        $widget_area_html_2 = ob_get_clean();

        if (is_single() && !is_admin() && ampforwp_is_amp_endpoint()) {
            return $this->insert_after_paragraph($widget_area_html_2, 3, $content);
        }

        return $content;
    }

    public function insert_middle()
    {
        if (is_active_sidebar('middle-single-note')) :
            return dynamic_sidebar('middle-single-note');
        endif;
    }

    public function insert_middle_mobile()
    {
        if (is_active_sidebar('middle-single-note-mobile')) :
            return dynamic_sidebar('middle-single-note-mobile');
        endif;
    }

    public function insert_middle_mob()
    {
        if (is_active_sidebar('note_mob_mid_1')) :
            return dynamic_sidebar('note_mob_mid_1');
        endif;
    }

   
    public function insert_custom_content($content)
    {

        ob_start();
        $this->insert_middle();
        $widget_area_html = ob_get_clean();

        if (is_single() && !is_admin() && !ampforwp_is_amp_endpoint()) {
            return $this->insert_after_paragraph($widget_area_html, 2, $content);
        }

        return $content;
    }

    public function insert_custom_content_2($content)
    {

        ob_start();
        $this->insert_middle_mobile();
        $widget_area_html_2 = ob_get_clean();

        if (is_single() && !is_admin() && !ampforwp_is_amp_endpoint()) {
            return $this->insert_after_paragraph($widget_area_html_2, 3, $content);
        }

        return $content;
    }

    public function insert_custom_content_3($content)
    {

        ob_start();
        $this->insert_middle_mob();
        $widget_area_html_2 = ob_get_clean();

        if (is_single() && !is_admin() && !ampforwp_is_amp_endpoint()) {
            return $this->insert_after_paragraph($widget_area_html_2, 3, $content);
        }

        return $content;
    }

   


    public function insert_after_paragraph($insertion, $paragraph_id, $content)
    {
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

    public function insert_custom_content_amp_1($content)
    {
        ob_start();
        $this->insert_middle_amp_1();
        $widget_area_html_2 = ob_get_clean();

        if (is_single() && !is_admin() && ampforwp_is_amp_endpoint()) {
            return $this->insert_before_paragraph($widget_area_html_2, 1, $content);
        }

        return $content;
    }
    
    public function insert_before_paragraph($insertion, $paragraph_id, $content)
    {
        $closing_p = '<p>';
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

    public function shortcode_portada($code)
    {
        return ADF()->show_ad($code);
    }

    /**
     * Sección
     */
    public function seccion_desktop_widgets()
    {
        $widgets = [
            'seccion_head_1' => __('Sección header 1', 'gen-base-theme'),
            'seccion_head_2' => __('Sección header 2', 'gen-base-theme'),
            'seccion_desk_1' => __('Sección box 1', 'gen-base-theme'),
            'seccion_desk_2' => __('Sección box 2', 'gen-base-theme'),
            'seccion_mob_1' => __('Sección Mobi 1', 'gen-base-theme'),
            'seccion_mob_2' => __('Sección Mobi 2', 'gen-base-theme'),
            'seccion_mob_3' => __('Sección Mobi 3', 'gen-base-theme'),
            'seccion_mob_4' => __('Sección Mobi 4', 'gen-base-theme'),
        ];

        foreach ($widgets as $key => $val) {
            register_sidebar(array(
                'name'          => $val,
                'id'            => $key,
                'before_widget' => '',
                'after_widget'  => '',
            ));
        }
    }

    /**
     * micrositio
     */
    public function micrositio_widgets()
    {
        $widgets = [
            'micrositio_head_1' => __('Micrositio header', 'gen-base-theme'),
            'micrositio_mob_1' => __('Micrositio mob header', 'gen-base-theme'),
        ];

        foreach ($widgets as $key => $val) {
            register_sidebar(array(
                'name'          => $val,
                'id'            => $key,
                'before_widget' => '',
                'after_widget'  => '',
            ));
        }
    }

    public function blockes_widgets()
    {
        $widgets = [
            'block_widget' => __('Bloque Publicidad', 'gen-base-theme'),
        ];

        foreach ($widgets as $key => $val) {
            register_sidebar(array(
                'name'          => $val,
                'id'            => $key,
                'before_widget' => '',
                'after_widget'  => '',
            ));
        }
    }
}

function widgets_ta()
{
    return new Widgets_Theme_TA();
}

widgets_ta();

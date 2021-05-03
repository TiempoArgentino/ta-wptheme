<?php

class TA_Micrositio{
    /**
    *   @property string Configuración del suplemento
    */
    private $settings = array(
        'title'                     => '',
        'custom_content'            => false,
    );

    /**
    *   @property array $micrositios                                            TA_Micrositio instances
    */
    static private $micrositios = array();

    /**
    *   @property bool $initialized                                             Indicates if the initialize method has been executed
    */
    static private $initialized = false;

    /**
    *   @property bool $setting_up_entities                                     Indicates if important entities are being set up
    */
    static private $setting_up_entities = false;

    /**
    *   @property WP_Term Term asociado con el suplemento
    */
    public $term = null;

    /**
    *   @property string Identificador del suplemento
    */
    public $slug = '';

    /**
    *   @property string Nombre del suplemento
    */
    public $title = '';

    /**
    *   @property string Prioridad del suplemento. Se puede usar para ordenar la
    *   lista de suplementos de acuerdo a su importancia. Menor priority mayor importancia.
    */
    public $priority = 10;
    /**
    *   @property WP_Post Página con el contenido del suplemento
    */
    private $content_page = null;

    /**
    *   @property bool Indica si existe contenido para esta pagina, en base a
    *   su configuración (custom_content) y si la pagina del home del suplemento
    *   tiene contenido y esta publicada.
    */
    public $has_custom_content = false;

    static public function initialize(){
        if( self::$initialized )
            return
        self::$initialized = true;
        RB_Filters_Manager::add_action("ta-theme-activation-micrositio-status", 'after_switch_theme', function(){
            TA_Micrositio::$setting_up_entities = true;
        });
        RB_Filters_Manager::add_filter('ta_micrositio_home_post_redirect', 'single_template', array(self::class, 'suplement_home_post_redirect'));
    }

    /**
    *   @param string $slug                     String que identifica al suplemento y a su term
    *   @param array $settings                  Array de opciones, desarrollado en /micrositios/README.md
    */
    public function __construct($slug, $settings){
        $this->settings = array_merge($this->settings, $settings);
        $this->slug = $slug;
        $this->title = isset($settings['title']) ? $settings['title'] : '';
        $this->priority = isset($settings['priority']) ? $settings['priority'] : $this->priority;
        self::$micrositios[$slug] = $this;
        //Algunos datos se establecen una vez que se asocia la instancia a su respectivo WP_Term

        RB_Filters_Manager::add_action("ta-setup-micrositio-$slug-entities", 'after_switch_theme', array($this,'create_entities'));
        RB_Filters_Manager::add_action("ta-setup-micrositio-$slug-set-data", 'init',  array($this,'set_entities_data'), array(
            'priority'  => 100,
        ));

        register_activation_hook( __FILE__, array( $this, 'after_switch_theme' ) );
        //register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivation' ) );
    }

    static public function is_setting_up_entities(){
        return self::$setting_up_entities;
    }

    /**
    *   Redirecciona el post del home de suplemento a la pagina de la taxonomia del
    *   suplemento. El post solo sirve para cargar el contenido personalizado del archive
    *   de la taxonomia.
    */
    static public function suplement_home_post_redirect($template){
        $post = get_queried_object();
        if($post->post_type != 'ta_micrositio_home')
            return $template;
        $suplement = TA_Micrositio::get_micrositio($post->post_name);
        wp_redirect( $suplement->archive_url );
        exit;
        return $template;
    }

    /**
    *
    */
    public function create_entities(){
        $this->create_term();
        $this->create_content_page();
    }

    public function create_term(){
        if(!term_exists($this->slug, 'ta_article_micrositio')){
            wp_insert_term($this->title, 'ta_article_micrositio', array(
                'slug'  => $this->slug,
            ));
        }
    }

    /**Crea si no existe el post por el cual se carga el contenido de la home del micrositio, si
    *esta configurado para tener contenido personalizado, con 'custom_content' = true*/
    public function create_content_page(){
        $content_page = RB_Posts_Module::get_post_by($this->slug, 'post_name', 'ta_micrositio_home');
        if(!$this->get_setting('custom_content')){//Este suplemento no maneja contenido personalizado
            self::delete_custom_content($this->slug);
        }
        else if(!$content_page){
            $content_page_id = wp_insert_post(array(
                'post_title'    => $this->title,
                'post_name'     => $this->slug,
                'post_type'     => 'ta_micrositio_home',
                'meta_input'    => array(
                    'micrositio_slug'   => $this->slug,
                ),
            ));
        }
    }

    public function set_entities_data(){
        $this->set_content_page_data();
        $this->set_term_data();
    }

    public function set_content_page_data(){
        $content_page = RB_Posts_Module::get_post_by($this->slug, 'post_name', 'ta_micrositio_home');
        $this->content_page = $content_page;
        $this->has_custom_content = $content_page && $content_page->post_status == 'publish' && $content_page->post_content;
    }

    //Asocia la instancia al WP_Term del suplemento. Si no existe, lo crea.
    public function set_term_data(){
        $this->term = get_term_by('slug', $this->slug, 'ta_article_micrositio');
        if( $this->term ){
            $this->ID = $this->term->term_id;
            $this->archive_url = $this->get_archives_url();
        }
    }

    static public function get_micrositio($slug){
        return $slug && isset(self::$micrositios[$slug]) ? self::$micrositios[$slug] : null;
    }

    /**
     *  Devuelve el link al archivo de articulos del suplemento
     *  @return string
     */
    public function get_archives_url(){
        return $this->is_public() && !$this->is_empty() ? get_term_link($this->term, 'lr-article-suplement') : '';
    }

    /**
    *   Indica si el suplemento debe ser visible.
    *   @return bool
    */
    public function is_public(){
        return isset($this->settings['public']) ? $this->settings['public'] : true;
    }

    /**
     *  Indica si no hay articulos cargados para este suplemento
     *  @return bool
     */
    public function is_empty(){
        return $this->term ? !$this->term->count : true;
    }

    public function get_content(){
        return $this->has_custom_content ? $this->content_page->post_content : '';
    }

    //Devuelve una configuración dado su nombre
    public function get_setting($setting_name){
        return isset($this->settings[$setting_name]) ? $this->settings[$setting_name] : null;
    }

    /**
    *   Borra el post que contiene el contenido personalizado del home de este suplemento
    *   @param string $suplement_slug
    */
    static public function delete_custom_content($suplement_slug){
        $content_page = RB_Posts_Module::get_post_by($suplement_slug, 'post_name', 'ta_micrositio_home');
        if($content_page)
            wp_delete_post($content_page->ID, true);
        return;
    }

    /**
    *   Elimina el suplemento de terms y de todos los articulos asociados
    *   @param string $suplement_slug
    */
    static public function delete_suplement($suplement_slug){
        $term = get_term_by('slug', $suplement_slug, 'ta_article_micrositio');
        if($term)
            wp_delete_term( $term->term_id, 'ta_article_micrositio' );
        self::delete_custom_content($suplement_slug);
    }

    public function get_name(){
        return $this->term ? $this->term->name : '';
    }

    public function get_sponsor(){
        $sponsor_meta = get_term_meta($this->term->term_id, 'ta_micrositio_sponsor', true);
        $result = array(
            'logo'      => null,
            'name'      => '',
            'link'      => '',
        );

        if($sponsor_meta && is_array($sponsor_meta)){
            if(isset($sponsor_meta['logo']) && $sponsor_meta['logo']){
                $result['logo'] = wp_get_attachment_url($sponsor_meta['logo']);
            }

            if(isset($sponsor_meta['name']) && $sponsor_meta['name']){
                $result['name'] = $sponsor_meta['name'];
            }

            if(isset($sponsor_meta['link']) && $sponsor_meta['link']){
                $result['link'] = $sponsor_meta['link'];
            }
        }

        return $result;
    }
}

TA_Micrositio::initialize();

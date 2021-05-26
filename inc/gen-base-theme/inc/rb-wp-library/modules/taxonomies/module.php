<?php
if(!class_exists('RB_Taxonomies_Module')){
    class RB_Taxonomies_Module extends RB_Framework_Module{
        static private $initialized = false;

        static public function initialize(){
            if(self::$initialized)
                return false;
            self::$initialized = true;
            self::add_rb_config_support();
        }

        /**
        *   Adds support for extra config when creating a taxonomy.
        *   The extra configuration goes into an extra argument `rb_config`, in
        *   the arguments array on register_taxonomy
        *   @param bool unique                                                  Indicates if a post can only have one of said terms.
        *                                                                       In the front, the component used to add terms must recognize
        *                                                                       the rb_config['unique'] argument. If not, the component may allow
        *                                                                       to add more terms, but the backend will only add one.
        */
        static private function add_rb_config_support(){
            add_filter( 'rest_prepare_taxonomy', array(self::class, 'rest_add_rb_config'), 10, 3);
            add_action( 'registered_taxonomy', array(self::class, 'add_rb_config'), 10, 3);
            // add_action( 'registered_taxonomy', array(self::class, 'redirect_taxonomy_templates'), 10, 3);
            add_action( 'set_object_terms', array(self::class, 'filter_unique_tax_terms'), 10, 6 );
        }

        /**
        *   Adds the rb_config to the taxonomy request response
        */
        static public function rest_add_rb_config($response, $taxonomy, $rest_request){
            $taxonomy->unique = true;
            $response->data['rb_config'] = $taxonomy->rb_config;
            return $response;
        }

        /**
        *   Merges the rb_config argument with default values.
        */
        static public function add_rb_config($taxonomy, $object_type, $tax_args){
            global $wp_taxonomies;
        	$tax_object = $wp_taxonomies[ $taxonomy ];
        	$rb_config_default = array(
        		'unique'	=> false,
                'required'  => false,
                'templates' => null,
        	);
        	$rb_config = isset($tax_object->rb_config) ? $tax_object->rb_config : [];
        	$tax_object->rb_config = array_merge($rb_config_default, $rb_config);
            $tax_object->rb_config['labels'] = array(
                'required_term_missing'    => "Please select a {$tax_object->labels->singular_name}",
            );

            if( isset($rb_config['labels']) )
                $tax_object->rb_config['labels'] = array_merge($tax_object->rb_config['labels'], $rb_config['labels']);
        }

        /**
        *   Redirects templates if needed
        */
        static public function redirect_taxonomy_templates($taxonomy, $object_type, $tax_args){
            global $wp_taxonomies;
            $tax_object = $wp_taxonomies[ $taxonomy ];
            redirect_object_templates($taxonomy, 'taxonomy', $tax_object->rb_config['templates']);
        }

        /**
        *   Removes extra terms on unique taxonomies that only accept maximum one term
        */
        static public function filter_unique_tax_terms($object_id, $terms, $tt_ids, $taxonomy, $append, $old_tt_ids){
            global $wp_taxonomies;
            $tax_object = $wp_taxonomies[ $taxonomy ];
            $is_unique = $tax_object->rb_config['unique'];
            if(!$is_unique)
                return false;

            $terms = get_the_terms( $object_id, $taxonomy );
            if(!$terms || is_wp_error($terms) || count($terms) <= 1)
                return;

            unset($terms[0]); // Remove the first term that will be the unique
            $terms_to_remove = array_map(function($term){ return $term->term_id; }, $terms);
            wp_remove_object_terms($object_id, $terms_to_remove, $taxonomy);
        }
    }

    RB_Taxonomies_Module::initialize();
}

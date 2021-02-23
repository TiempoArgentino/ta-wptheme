<?php

if(!class_exists('RB_Wordpress_Form_Handler')){
    class RB_Wordpress_Form_Handler{
        static $handlers_created = array();

        public $options = array(
            'AJAX'  => false,
        );

        public function __construct($hook, $form_handler, $args = array()){
            if(!isset($hook) || !is_string($hook) || isset(self::$handlers_created[$hook]) || !is_callable($form_handler)){
                return null;
            }

            $this->hook = $hook;
            $this->options = array_merge($this->options, $args);
            $this->form_handler = $form_handler;

            $this->hook_form_handler();
            self::$handlers_created[$hook] = $this;
        }

        // =========================================================================
        // GETTERS
        // =========================================================================
        public function get_form_action(){
            return $this->is_AJAX() ? esc_url( admin_url('admin-ajax.php') ) : esc_url( admin_url('admin-post.php') );
        }

        public function get_hook_name(){
            return $this->hook;
        }

        public function is_AJAX(){
            return $this->options['AJAX'];
        }

        //Returns, if exists, the instance for the hook given
        static function get_form_handler($hook){
            return is_string($hook) ? self::$handlers_created[$hook] : null;
        }

        // =========================================================================
        // METHODS
        // =========================================================================
        private function hook_form_handler(){
            $hook = $this->get_hook_name();
            $hook = $hook ? '_' . $hook : '';
            if( $this->is_AJAX() ){
                add_action( 'wp_ajax_nopriv' . $hook, $this->form_handler );
                add_action( 'wp_ajax' . $hook, $this->form_handler );
            }
            else{
                add_action( 'admin_post_nopriv' . $hook, $this->form_handler );
                add_action( 'admin_post' . $hook, $this->form_handler );
            }
        }

        /**
        *   Registers a function to be called that should print the form content
        *   @param function $callback
        */
        public function register_form_content($callback){
            $this->options['form_content'] = $callback;
        }

        // =========================================================================
        // PRINTERS
        // =========================================================================
        public function print_form(){
            ?>
            <form action="<?php echo $this->get_form_action(); ?>" method="post">
                <?php $this->print_form_action_input(); ?>
                <?php $this->print_form_content(); ?>
            </form>
            <?php
        }

        public function print_form_content(){
            if(is_callable($this->options['form_content']))
                $this->options['form_content']($this);
        }

        public function print_form_action_input(){
            ?><input type="hidden" name="action" value="<?php echo $this->get_hook_name(); ?>"><?php
        }
    }
}

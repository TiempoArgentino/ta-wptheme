<?php
class RB_Gutenberg_Module extends RB_Framework_Module{
    static private $autop_disabled = false;
    static private $initialized = false;

    static public function initialize(){
        if(self::$initialized)
            return false;
        self::$initialized = true;

        require_once plugin_dir_path(__FILE__) . 'inc/classes/RB_Gutenberg_Block.php';
        require_once plugin_dir_path(__FILE__) . 'inc/classes/RB_Gutenberg_Categories.php';
        require_once plugin_dir_path(__FILE__) . 'inc/functions.php';
    }
    /**
    *   Parse a gutenberg content string into an HTML string
    *   @param mixed[] $args
    *   Array of options
    *       @param bool $apply_content_filter                           Indicated if the 'the_content' filter should be
    *                                                                   applied on the resulting HTML string.
    *       @param bool $disable_autop_not_dynamic_block                If autop should be disabled for regular blocks
    *       @param bool $disable_autop_dynamic_block                    If autop should be disabled for
    */
    static public function parse_content($content, $args = array()){
        $default_args = array(
            'apply_content_filter'              => true,
            'disable_autop'                     => true,
            'disable_autop_dynamic_block'       => true,
            'disable_autop_not_dynamic_block'   => true,
        );
        $args = array_merge($default_args, $args);
        extract($args);

        //Disabled AUTOP for this content
        $autop_was_enabled = has_filter( 'the_content', 'wpautop' );

        //SET THE HTML
        $html = '';
        $blocks = parse_blocks($content);

        foreach ( $blocks as $block ) {
            $is_dynamic = self::is_dynamic($block['blockName']);
            $disable_block_autop = ($is_dynamic && $disable_autop_dynamic_block) || (!$is_dynamic && $disable_autop_not_dynamic_block);
            $block_html = render_block( $block );
            if($apply_content_filter){
                if($disable_block_autop)
                    remove_filter( 'the_content', 'wpautop' );
                else
                    add_filter( 'the_content', 'wpautop' );

                $block_html = apply_filters('the_content', $block_html);
            }
            $html .= $block_html;
        }

        //Set AUTOP back to its old value
        if($apply_content_filter){
            if(!$autop_was_enabled && !$disable_autop)//Autop was disabled and was enabled for this content
                remove_filter( 'the_content', 'wpautop' );
            elseif($autop_was_enabled && $disable_autop)//if autop was enabled and we disabled it for this content
                add_filter( 'the_content', 'wpautop' );
        }

        return $html;
    }

    /**
    *   Retrieves a registered block type
    *   @param string $block_name                           The blocks name ($block['blockName']);
    */
    static public function get_block_type($block_name){
        return WP_Block_Type_Registry::get_instance()->get_registered( $block_name );
    }

    /**
    *   If a given block is a dynamic one
    *   @param string $block_name                           The blocks name ($block['blockName']);
    *   @return WP_Block_Type
    */
    static public function is_dynamic($block_name){
        $block_type = self::get_block_type($block_name);
        return  $block_type ? $block_type->is_dynamic() : null;
    }
}

RB_Gutenberg_Module::initialize();

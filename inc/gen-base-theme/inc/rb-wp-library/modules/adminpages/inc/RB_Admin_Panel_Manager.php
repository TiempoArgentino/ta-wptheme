<?php
/*Statics function that facilitates some functionalities without having to mess with hooks and actions
Removing pages - Call function on a page -
*/

class RB_Admin_Panel_Manager{
    static private $removed_pages = array();
    static private $removed_subpages = array();
    static private $on_page_functions = array();

    static function initialize(){
        self::hook_pages_removal();
        self::hook_on_page_functions();
    }

    // =========================================================================
    // REMOVE PAGE
    // =========================================================================

    //Prepares to remove an admin page from the admin menu
    static public function remove_page($menu_slug){
        array_push(self::$removed_pages, $menu_slug);
    }

    //Prepares to remove a subpage from an admin menu item
    static public function remove_subpage($menu_slug, $subpage_slug){
        self::$removed_subpages[$menu_slug] = $subpage_slug;
    }

    //Removes all pages and subpages added for removal
    static public function remove_pages(){
        foreach(self::$removed_pages as $page_slug){
            remove_menu_page("$page_slug");
        }
        foreach(self::$removed_subpages as $menu_slug => $subpage_slug){
            remove_submenu_page("$menu_slug", "$subpage_slug");
        }
    }

    //Hook pages removal to admin_menu
    static private function hook_pages_removal(){
        add_action( 'admin_menu', array(self::class, 'remove_pages'), 999 );
    }

    // =========================================================================
    // PAGE INFO
    // =========================================================================
    //Doesnt really work - dont use it :(
    static public function get_page_hook($menu_slug){
        global $admin_page_hooks;
        return $admin_page_hooks[ $menu_slug ];
    }

    // =========================================================================
    // CALL ON PAGE
    // =========================================================================
    //Hook a callback function to only be called on a certain admin page
    static public function call_on_page($menu_slug, $callback){
        if(!is_string($menu_slug) || !is_callable($callback))
            return false;

        array_push(self::$on_page_functions, array(
            'hook'      => $menu_slug,
            'callback'  => $callback,
        ));
    }

    static public function add_on_page_callbacks(){
        foreach(self::$on_page_functions as $callback_data){
            add_action( 'load-' . $callback_data['hook'], $callback_data['callback'] );
        }
    }

    static private function hook_on_page_functions(){
        add_action( 'admin_menu', array(self::class, 'add_on_page_callbacks'), 999 );
    }

    static public function forbid_access_to_page($menu_slug, $redirect = true){
        self::remove_page($menu_slug);
        array_push(self::$on_page_functions, array(
            'hook'      => $menu_slug,
            'callback'  => function() use ($redirect){
                ob_start();
                ?>
                <h1>Access Forbidden</h1>
                <p>We are sorry <?php echo translate_smiley([':(']); ?>, but access to this page is forbidden for your permissions level</p>
                <?php
                $message = ob_get_clean();
                wp_die($message, "Access Forbidenn");
            },
        ));
    }
}

RB_Admin_Panel_Manager::initialize();

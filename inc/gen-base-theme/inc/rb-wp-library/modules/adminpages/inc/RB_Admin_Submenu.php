<?php
/*The RB_Admin_Submenu create a new submenu item in the wp admin menu*/
/*A page is created on construct, and subpages can be added using the add_subpage method*/
class RB_Admin_Submenu extends RB_Admin_Menu_Item{
    public $pages = array();

    public function __construct($menu_slug, $page_title, $menu_title, $capability, $renderer = '', $icon_url = '', $position = null ) {
        $this->page_title = $page_title;
        $this->menu_title = $menu_title;
        $this->capability = $capability;
        $this->menu_slug = $menu_slug;
        $this->renderer = $renderer;
        $this->icon_url = $icon_url;
        $this->position = $position;

        $this->hook_admin_menu();
        return $this;
    }

    // =========================================================================
    // HOOK ADMIN MENU
    // =========================================================================
    public function add_menu_page(){
        $this->hook = add_menu_page($this->page_title, $this->menu_title, $this->capability, $this->menu_slug, $this->renderer, $this->icon_url, $this->position);
        $this->on_hook_created();
        //add_action( 'load-' . $this->hook, 'load_admin_js' );
    }

    private function hook_admin_menu(){
        add_action('admin_menu', array($this, 'add_menu_page'));
    }

    // =========================================================================
    // SUBPAGES
    // =========================================================================
    public function add_subpage($subpage_slug, $subpage_title, $subpage_menu_title, $subpage_capability, $subpage_renderer = ''){
        $this->pages[$subpage_slug] = new RB_Admin_Submenu_Page($subpage_slug, $this->menu_slug, $subpage_title, $subpage_menu_title, $subpage_capability, $subpage_renderer);
        return $this;
    }

    // =========================================================================
    // REMOVE
    // =========================================================================
    public function hide(){
        RB_Admin_Panel_Manager::remove_page($this->menu_slug);
    }
}

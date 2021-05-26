<?php
class RB_Admin_Submenu_Page extends RB_Admin_Menu_Item{
    public function __construct($menu_slug, $parent_slug, $page_title, $menu_title, $capability, $renderer = '') {
        $this->parent_slug = $parent_slug;
        $this->menu_slug = $menu_slug;
        $this->page_title = $page_title;
        $this->menu_title = $menu_title;
        $this->capability = $capability;
        $this->renderer = $renderer;

        $this->hook_admin_submenu_page();
    }

    public function add_submenu_page(){
        $this->hook = add_submenu_page($this->parent_slug, $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, $this->renderer);
        $this->on_hook_created();
    }

    private function hook_admin_submenu_page(){
        add_action('admin_menu', array($this, 'add_submenu_page'));
    }
}

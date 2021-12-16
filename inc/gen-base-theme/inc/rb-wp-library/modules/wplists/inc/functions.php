<?php

function rb_add_posts_list_column($id, $admin_pages, $title, $render_callback, $args = array()){
    return new RB_Posts_List_Column($id, $admin_pages, $title, $render_callback, $args);
}

function rb_add_terms_list_column($id, $admin_pages, $title, $render_callback, $args = array()){
    return new RB_Terms_List_Column($id, $admin_pages, $title, $render_callback, $args);
}

function rb_remove_posts_list_column($filter_id, $posts_types, $columns_remove, $args = array()){
    return RB_Posts_List_Column::remove($filter_id, $posts_types, $columns_remove, $args);
}

function rb_remove_terms_list_column($filter_id, $taxonomies_names, $columns_remove, $args = array()){
    return RB_Terms_List_Column::remove($filter_id, $taxonomies_names, $columns_remove, $args);
}

<?php
//========================================
//	REMOVE CORE COLUMNS
//========================================
RB_Posts_List_Column::remove('remove_base_posts_columns', 'post', ['tags', 'author', 'categories', 'comments', 'date']);
RB_Terms_List_Column::remove('remove_base_tax_columns', ['category', 'post_tag'], ['slug', 'description', 'posts']);

//========================================
//	ADD CUSTOM COLUMNS
//========================================
new RB_Posts_List_Column('post_test_column', 'post', 'Test Column', function($column, $post){
    echo 'Test column with static content';
}, array(
    'position'      => 4,
    'column_class'  => 'test-class',
));

new RB_Terms_List_Column('category_test_column', 'category', 'Category Column', function($column, $term){
    echo 'Test column with static content';
}, array(
    'position'      => 4,
    'column_class'  => 'test-class',
));

//========================================
//	HOOK REMOVAL
//========================================
/**** Adding this code removes the previous core columns removal ****/
// RB_Filters_Manager::remove_filter('remove_base_posts_columns');
// RB_Filters_Manager::remove_filter('remove_base_tax_columns-category');
/**** Remove the custom columns additions ****/
// RB_Filters_Manager::remove_filter("rb_tax_metabox-post_test_column-column_base");
// RB_Filters_Manager::remove_filter("rb_tax_metabox-category_test_column-column_base");

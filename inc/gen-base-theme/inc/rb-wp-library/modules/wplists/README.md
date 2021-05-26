# Wordpress Admin Lists

Functionalities to manage columns in Posts and Terms lists.

The main functionalities (add and remove columns), takes the same type of arguments for both Posts and Terms lists, but are done with different functions.

- For **posts columns**, use `rb_add_posts_list_column` and `rb_remove_posts_list_column`.
- For **taxonomies column**, use `rb_add_terms_list_column` and `rb_remove_terms_list_column`.

# Create a column

To create a column, use `rb_add_posts_list_column` for posts, or `rb_add_terms_list_column` for terms list. The arguments are the following.

| Parameter        	| Type             	| Default 	| Required 	| Description                                                                                                                                                                                        	|
|------------------	|------------------	|---------	|----------	|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	|
| $column_id       	| string           	| null    	| Yes      	| ID of the new column.                                                                                                                                                                              	|
| $admin_pages     	| string\|string[] 	| null    	| Yes      	| The admin pages where this column will be added. Posts IDs for posts, taxonomies names for taxonomies                                                                                              	|
| $column_title    	| string           	| null    	| Yes      	| The column header title                                                                                                                                                                            	|
| $render_callback 	| callable         	| null    	| Yes      	| Function that prints the column cell content. It takes 2 parameters <br> @param string $column: The column ID <br> @param WP_Post\|WP_Term\|mixed $wp_object: The object of the row. Post or Term. 	|
| $args            	| mixed[]          	| []      	| No       	| Extra arguments                                                                                                                                                                                    	|

#### Extra arguments ($args)

| Parameter    	| Type   	| Default     	| Description                                        	|
|--------------	|--------	|-------------	|----------------------------------------------------	|
| position     	| int    	| Last column 	| Position of the column on the objects list table   	|
| column_class 	| string 	| ''          	| HTML class for the column to be styled or queried. 	|

### Examples

````php
<?php
// POST COLUMN - Adding column to core post type
rb_add_posts_list_column('post_test_column', 'post', 'Test Column', function($column, $post){
    echo "Column content";
}, array(
    'position'      => 4,
    'column_class'  => 'test-class',
));
// TAXONOMY COLUMN - Adding column to core category taxonomy
rb_add_terms_list_column('category_test_column', 'category', 'Test Column', function($column, $term){
    echo "Column content";
}, array(
    'position'      => 4,
    'column_class'  => 'test-class',
));


// REMOVE PREVIOUS CHANGES
RB_Filters_Manager::remove_filter("rb_tax_metabox-post_test_column-column_base");
RB_Filters_Manager::remove_filter("rb_tax_metabox-category_test_column-column_base");
````

# Remove a column

Use `rb_remove_posts_list_column` or `rb_remove_terms_list_column` to remove one or more columns from one or more entity.


| Parameter    	| Type             	| Default 	| Required 	| Description                                                                                                                                                                                                                                                                                                          	|
|--------------	|------------------	|---------	|----------	|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	|
| $filter_id   	| string           	| null    	| Yes      	| ID for the filter stored in the filter manager. It allows tor remove this filter using  RB_Filters_Manager::remove_filter. <br> If `$admin_pages` is an array of pages (posts ids, taxonomies names, etc), then a filter for each admin_page is created. The filter ID for each page is `{$filter_id}-${admin_page}` 	|
| $admin_pages 	| string\|string[] 	| null    	| Yes      	| The admin pages where this columns will be removed. Posts IDs for posts, taxonomies names for taxonomies                                                                                                                                                                                                             	|
| $columns     	| string\|string[] 	| null    	| Yes      	| Column or columns ids to remove                                                                                                                                                                                                                                                                                      	|
| $args        	| mixed[]          	| []      	| No       	| Extra arguments                                                                                                                                                                                                                                                                                                      	|

#### Extra arguments ($args)

| Parameter 	| Type 	| Default 	| Description                                        	|
|-----------	|------	|---------	|----------------------------------------------------	|
| priority  	| int  	| 10      	| Priority of the filters used to remove the columns 	|

### Examples

````php
<?php
//REMOVING CORE COLUMNS
rb_remove_posts_list_column('remove_base_posts_columns', 'post', ['tags', 'author', 'categories', 'comments', 'date']);
rb_remove_terms_list_column('remove_base_tax_columns', ['category', 'post_tag'], ['slug', 'description', 'posts']);

// Removing filters created by the previous methods. This will leave the columns as they were
RB_Filters_Manager::remove_filter('remove_base_posts_columns');
RB_Filters_Manager::remove_filter('remove_base_tax_columns-category');
RB_Filters_Manager::remove_filter('remove_base_tax_columns-post_tag');
````

<?php

/***************************************************************
*   COLUMN
****************************************************************/


/*
 * This action hook allows to add a new empty column
 */
add_filter('manage_post_posts_columns', 'misha_featured_image_column');
function misha_featured_image_column( $column_array ) {

	// I want to add my column at the beginning, so I use array_slice()
	// in other cases $column_array['featured_image'] = 'Featured Image' will be enough
	$column_array = array_slice( $column_array, 0, 1, true )
	+ array('featured_image' => 'Featured Image') // our new column for featured images
	+ array_slice( $column_array, 1, NULL, true );

	return $column_array;
}

/*
 * This hook will fill our column with data
 */
add_action('manage_posts_custom_column', 'misha_render_the_column', 10, 2);
function misha_render_the_column( $column_name, $post_id ) {

	if( $column_name == 'featured_image' ) {

		// if there is no featured image for this post, print the placeholder
		if( has_post_thumbnail( $post_id ) ) {

			// I know about get_the_post_thumbnail() function but we need data-id attribute here
			$thumb_id = get_post_thumbnail_id( $post_id );
			echo '<img data-id="' . $thumb_id . '" src="' . wp_get_attachment_url( $thumb_id ) . '" />';

		} else {

			// data-id should be "-1" I will explain below
			echo '<img data-id="-1" src="' . get_stylesheet_directory_uri() . '/placeholder.png" />';

		}

	}

}

/***************************************************************
*   QUICK EDIT CONTENT
****************************************************************/

add_action('quick_edit_custom_box',  'misha_add_featured_image_quick_edit', 10, 2);
function misha_add_featured_image_quick_edit( $column_name, $post_type ) {

	// add it only if we have featured image column
	if ($column_name != 'featured_image') return;

	// we add #misha_featured_image to use it in JavaScript in CSS
	echo '<fieldset id="misha_featured_image" class="inline-edit-col-left">
		<div class="inline-edit-col">
			<span class="title">Featured Image</span>
			<div>
				<a href="#" class="misha_upload_featured_image">Set featured image</a>
				<input type="hidden" name="_thumbnail_id" value="" />
				<a href="#" class="misha_remove_featured_image">Remove Featured Image</a>
			</div>
		</div></fieldset>';

		// please look at _thumbnail_id as a name attribute - I use it to skip save_post action

}

<?php

//====================================================================
//  #1 REGISTER COMMENT CUSTOM META
//====================================================================

RB_Filters_Manager::add_action('ta_comment_author_meta_register', 'init', function(){
    register_meta('comment', 'ta_comment_author', array(
        'single' 	=> true,
        'type' 		=> 'number',
        'show_in_rest' => array(
            'schema' => array(
                'type'  => 'number',
            ),
        ),
    ));
});

//====================================================================
//  #2 DISPLAY FIELDS IN REPLY FORM (COMMENT REPLY AND QUICK EDIT)
//====================================================================

RB_Filters_Manager::add_filter('ta_comment_reply_form', 'wp_comment_reply', function($empty, $args){
	global $wp_list_table;
	$table_row = true;
	extract($args);

	if ( ! $wp_list_table ) {
		if ( 'single' === $mode ) {
			$wp_list_table = _get_list_table( 'WP_Post_Comments_List_Table' );
		} else {
			$wp_list_table = _get_list_table( 'WP_Comments_List_Table' );
		}
	}

	ob_start();
	?>
	<form method="get">
	<?php if ( $table_row ) : ?>
	<table style="display:none;">
	<tbody id="com-reply">
	<tr id="replyrow" class="inline-edit-row" style="display:none;">
	<td colspan="<?php echo $wp_list_table->get_column_count(); ?>" class="colspanchange">
	<?php else : ?>
	<div id="com-reply" style="display:none;">
	<div id="replyrow" style="display:none;">
	<?php endif; ?>
		<fieldset class="comment-reply">
		<legend>
			<span class="hidden" id="editlegend"><?php _e( 'Edit Comment' ); ?></span>
			<span class="hidden" id="replyhead"><?php _e( 'Reply to Comment' ); ?></span>
			<span class="hidden" id="addhead"><?php _e( 'Add new Comment' ); ?></span>
		</legend>

		<div id="replycontainer">
		<label for="replycontent" class="screen-reader-text"><?php _e( 'Comment' ); ?></label>
		<?php
		$quicktags_settings = array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close' );
		wp_editor(
			'',
			'replycontent',
			array(
				'media_buttons' => false,
				'tinymce'       => false,
				'quicktags'     => $quicktags_settings,
			)
		);
		?>
		</div>

		<div id="edithead">
			<div class="inside">
			<label for="author-name"><?php _e( 'Name' ); ?></label>
			<input type="text" name="newcomment_author" size="50" value="" id="author-name" />
			</div>

			<div class="inside">
			<label for="author-email"><?php _e( 'Email' ); ?></label>
			<input type="text" name="newcomment_author_email" size="50" value="" id="author-email" />
			</div>

			<div class="inside">
			<label for="author-url"><?php _e( 'URL' ); ?></label>
			<input type="text" id="author-url" name="newcomment_author_url" class="code" size="103" value="" />
			</div>
		</div>

        <div id="custom-comment-meta-controls">
			<div class="meta-control">
				<field class="field photographer-field">
					<!-- <h3>Autor</h3> -->
                    <!-- <p>El autor seleccionado debe corresponder con alguno de los autores del artículo. Sino, se seleccionará automáticamente. Si el artículo es de un solo autor, no hace falta llenar este campo.</p> -->
					<input rb-control-value type="hidden" class="text meta-value" id="ta_comment_author" name="ta_comment_author" value="">
				</field>
			</div>
		</div>

		<div id="replysubmit" class="submit">
			<p class="reply-submit-buttons">
				<button type="button" class="save button button-primary">
					<span id="addbtn" style="display: none;"><?php _e( 'Add Comment' ); ?></span>
					<span id="savebtn" style="display: none;"><?php _e( 'Update Comment' ); ?></span>
					<span id="replybtn" style="display: none;"><?php _e( 'Submit Reply' ); ?></span>
				</button>
				<button type="button" class="cancel button"><?php _e( 'Cancel' ); ?></button>
				<span class="waiting spinner"></span>
			</p>
			<div class="notice notice-error notice-alt inline hidden">
				<p class="error"></p>
			</div>
		</div>

		<input type="hidden" name="action" id="action" value="" />
		<input type="hidden" name="comment_ID" id="comment_ID" value="" />
		<input type="hidden" name="comment_post_ID" id="comment_post_ID" value="" />
		<input type="hidden" name="status" id="status" value="" />
		<input type="hidden" name="position" id="position" value="<?php echo $position; ?>" />
		<input type="hidden" name="checkbox" id="checkbox" value="<?php echo $checkbox ? 1 : 0; ?>" />
		<input type="hidden" name="mode" id="mode" value="<?php echo esc_attr( $mode ); ?>" />
		<?php
			wp_nonce_field( 'replyto-comment', '_ajax_nonce-replyto-comment', false );
		if ( current_user_can( 'unfiltered_html' ) ) {
			wp_nonce_field( 'unfiltered-html-comment', '_wp_unfiltered_html_comment', false );
		}
		?>
		</fieldset>
	<?php if ( $table_row ) : ?>
	</td>
	</tr>
	</tbody>
	</table>
	<?php else : ?>
	</div></div>
		<?php endif; ?>
	</form>
	<?php

	return ob_get_clean();
}, array(
    'accepted_args' => 2,
));

//====================================================================
//  #3.1 SAVE METADATA BY INTERCEPTING CORE REPLY AJAX CALL
//====================================================================

RB_Filters_Manager::add_action('ta_admin_ajax_replyto-comment', 'admin_init', function(){
    RB_Filters_Manager::add_action( 'ta_ajax_replyto-comment', 'wp_ajax_replyto-comment', function( $action ) {
    	if ( empty( $action ) ) {
    		$action = 'replyto-comment';
    	}

    	check_ajax_referer( $action, '_ajax_nonce-replyto-comment' );

    	$comment_post_ID = (int) $_POST['comment_post_ID'];
    	$post            = get_post( $comment_post_ID );

    	if ( ! $post ) {
    		wp_die( -1 );
    	}

    	if ( ! current_user_can( 'edit_post', $comment_post_ID ) ) {
    		wp_die( -1 );
    	}

    	if ( empty( $post->post_status ) ) {
    		wp_die( 1 );
    	} elseif ( in_array( $post->post_status, array( 'draft', 'pending', 'trash' ), true ) ) {
    		wp_die( __( 'Error: You can&#8217;t reply to a comment on a draft post.' ) );
    	}

    	$user = wp_get_current_user();

    	if ( $user->exists() ) {
    		$user_ID              = $user->ID;
    		$comment_author       = wp_slash( $user->display_name );
    		$comment_author_email = wp_slash( $user->user_email );
    		$comment_author_url   = wp_slash( $user->user_url );
    		$comment_content      = trim( $_POST['content'] );
    		$comment_type         = isset( $_POST['comment_type'] ) ? trim( $_POST['comment_type'] ) : 'comment';

    		if ( current_user_can( 'unfiltered_html' ) ) {
    			if ( ! isset( $_POST['_wp_unfiltered_html_comment'] ) ) {
    				$_POST['_wp_unfiltered_html_comment'] = '';
    			}

    			if ( wp_create_nonce( 'unfiltered-html-comment' ) != $_POST['_wp_unfiltered_html_comment'] ) {
    				kses_remove_filters(); // Start with a clean slate.
    				kses_init_filters();   // Set up the filters.
    				remove_filter( 'pre_comment_content', 'wp_filter_post_kses' );
    				add_filter( 'pre_comment_content', 'wp_filter_kses' );
    			}
    		}
    	} else {
    		wp_die( __( 'Sorry, you must be logged in to reply to a comment.' ) );
    	}

    	if ( '' === $comment_content ) {
    		wp_die( __( 'Error: Please type your comment text.' ) );
    	}

    	$comment_parent = 0;

    	if ( isset( $_POST['comment_ID'] ) ) {
    		$comment_parent = absint( $_POST['comment_ID'] );
    	}

    	$comment_auto_approved = false;
    	$commentdata           = compact( 'comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID' );

    	// Automatically approve parent comment.
    	if ( ! empty( $_POST['approve_parent'] ) ) {
    		$parent = get_comment( $comment_parent );

    		if ( $parent && '0' === $parent->comment_approved && $parent->comment_post_ID == $comment_post_ID ) {
    			if ( ! current_user_can( 'edit_comment', $parent->comment_ID ) ) {
    				wp_die( -1 );
    			}

    			if ( wp_set_comment_status( $parent, 'approve' ) ) {
    				$comment_auto_approved = true;
    			}
    		}
    	}

    	$comment_id = wp_new_comment( $commentdata );

    	if ( is_wp_error( $comment_id ) ) {
    		wp_die( $comment_id->get_error_message() );
    	}

    	$comment = get_comment( $comment_id );

    	if ( ! $comment ) {
    		wp_die( 1 );
    	}

    	$position = ( isset( $_POST['position'] ) && (int) $_POST['position'] ) ? (int) $_POST['position'] : '-1';

    	ob_start();
    	if ( isset( $_REQUEST['mode'] ) && 'dashboard' === $_REQUEST['mode'] ) {
    		require_once ABSPATH . 'wp-admin/includes/dashboard.php';
    		_wp_dashboard_recent_comments_row( $comment );
    	} else {
    		if ( isset( $_REQUEST['mode'] ) && 'single' === $_REQUEST['mode'] ) {
    			$wp_list_table = _get_list_table( 'WP_Post_Comments_List_Table', array( 'screen' => 'edit-comments' ) );
    		} else {
    			$wp_list_table = _get_list_table( 'WP_Comments_List_Table', array( 'screen' => 'edit-comments' ) );
    		}
    		$wp_list_table->single_row( $comment );
    	}
    	$comment_list_item = ob_get_clean();

    	/*******************************************
    	*	CUSTOM COMMENTS META
    	*******************************************/
    	ta_custom_comments_meta_update($comment_id);

    	$response = array(
    		'what'     => 'comment',
    		'id'       => $comment->comment_ID,
    		'data'     => $comment_list_item,
    		'position' => $position,
    	);

    	$counts                   = wp_count_comments();
    	$response['supplemental'] = array(
    		'in_moderation'        => $counts->moderated,
    		'i18n_comments_text'   => sprintf(
    			/* translators: %s: Number of comments. */
    			_n( '%s Comment', '%s Comments', $counts->approved ),
    			number_format_i18n( $counts->approved )
    		),
    		'i18n_moderation_text' => sprintf(
    			/* translators: %s: Number of comments. */
    			_n( '%s Comment in moderation', '%s Comments in moderation', $counts->moderated ),
    			number_format_i18n( $counts->moderated )
    		),
    	);

    	if ( $comment_auto_approved ) {
    		$response['supplemental']['parent_approved'] = $parent->comment_ID;
    		$response['supplemental']['parent_post_id']  = $parent->comment_post_ID;
    	}

    	$x = new WP_Ajax_Response();
    	$x->add( $response );
    	$x->send();
    }, array(
        'priority'      => 1,
        'accepted_args' => 1,
    ) );
} );

//====================================================================
//  #3.2 SAVE COMMENT CUSTOM META DATA ON EDIT
//====================================================================

RB_Filters_Manager::add_action( 'ta_edit_comment_custom_meta_update', 'edit_comment', function($comment_ID, $data){
	ta_custom_comments_meta_update($comment_ID);
}, array(
    'accepted_args' => 2,
));

// UPDATE COMMENT METAS
function ta_custom_comments_meta_update($comment_id){
	/*******************************************
	*	CUSTOM COMMENTS META
	*******************************************/
	if( isset($_POST['ta_comment_author']) ){
		update_comment_meta($comment_id, 'ta_comment_author', $_POST['ta_comment_author']);
	}
}

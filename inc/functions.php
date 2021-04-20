<?php

function get_ta_articles_from_query($query_args){
    $articles = [];
	$result = rb_get_posts($query_args);
	$posts = $result['posts'];
	$query = $result['wp_query'];

	if($posts && !empty($posts) && !is_wp_error($posts)){
		foreach ($posts as $article_post) {
			$article = TA_Article_Factory::get_article($article_post, 'article_post');
			$article->populate(true);
			$articles[] = $article;
		}
	}

    return $articles;
}

/**
*   Focus position for the attachment image.
*   @param int $attachment_id
*   @return string[]
*/
function ta_get_attachment_positions($attachment_id){
    if(!is_int($attachment_id))
        return null;
    return array(
        'x'     => get_post_meta( $attachment_id, 'ta_attachment_position_x', true ),
        'y'     => get_post_meta( $attachment_id, 'ta_attachment_position_y', true ),
    );
}

/**
*   Sets the amount of cells rendered in the current ta/articles block row
*   @param int $count                                                           Amount of cells
*/
function register_articles_block_cells_count($count){
    set_query_var(TA_ARTICLES_CELLS_COUNT_VARNAME, $count);
}


/**
*   Increments the amount of cells rendered in the current ta/articles block row
*   @param int $count                                                           Amount of cells
*/
function update_articles_block_cells_count($count){
    register_articles_block_cells_count( get_articles_block_cells_count() + $count );
}

/**
*   @return int                                                                 The amount of cells rendered in the current ta/articles row block used
*/
function get_articles_block_cells_count(){
    return get_query_var(TA_ARTICLES_CELLS_COUNT_VARNAME);
}

/**
*	@param TA_Article_Data $article
*	@param mixed[] $settings
*/
function ta_render_article_preview($article, $settings = array()){
	if(!$article)
		return;

	$config = array();
	$article_preview_block = RB_Gutenberg_Block::get_block('ta/article-preview');
    $layout = isset($settings['layout']) ? $settings['layout'] : null;
	$layout = !$layout && $article->isopinion ? 'opinion' : $layout;
	$size = isset($settings['size']) ? $settings['size'] : null;
	$desktop_horizontal = isset($settings['desktop_horizontal']) ? $settings['desktop_horizontal'] : false;

	$article_preview_block->render( array(
		'article'				=> $article,
		'layout'				=> $layout,
		'size'					=> $size,
		'desktop_horizontal'	=> $desktop_horizontal,
	) );
}


/**
*   Devuelve un array de attributes que se usan para guardar los filtros de articulos
*   en los bloques.
*   @param mixed[] $filters                                 Array de filtros a aplicar. Acepta bools principalmente,
*                                                           pero puede tomar arrays para filtros con mas opciones, como
*                                                           valor 'default' de un filtro.
*   @return mixed[]
*/
function lr_get_article_filters_attributes($filters = array()){
    $default_filters = array(
        'most_recent'       => false,
        'amount'            => false,
        'suplements'        => false,
        'sections'          => false,
        'tags'              => false,
        'authors'           => false,
    );
    $filters = array_merge($default_filters, $filters);
    $attributes = array();

    if($filters['amount']){
        $amount_default = is_array($filters['amount']) && isset($filters['amount']['default']) ? $filters['amount']['default'] : 4;
        $attributes['amount'] = array(
            'type'      => 'integer',
            'default'   => $amount_default,
        );
    }

    if($filters['most_recent']){
        $most_recent_default = is_array($filters['most_recent']) && isset($filters['most_recent']['default']) ? $filters['most_recent']['default'] : false;
        $attributes['most_recent'] = array(
            'type'		=> 'bool',
            'default'	=> $most_recent_default,
        );
    }

    // if($filters['suplements']){
    //     $attributes['suplements'] = array(
    //         'type'		=> 'object',
    // 		'default'	=> array(
    // 			'terms'	=> null,
    // 		),
    //     );
    // }

    if($filters['sections']){
        $attributes['sections'] = array(
            'type'		=> 'object',
            'default'	=> array(
                'terms'	=> null,
            ),
        );
    }

    if($filters['tags']){
        $attributes['tags'] = array(
            'type'		=> 'object',
            'default'	=> array(
                'terms'	=> null,
            ),
        );
    }

    if($filters['authors']){
        $attributes['authors'] = array(
            'type'		=> 'object',
            'default'	=> array(
                'terms'	=> null,
            ),
        );
    }

    return $attributes;
}


/**
*   Devuelve un array de args para usar en una WP_Query, en base a los filtros
*   guardados en los attributes de un bloque
*   @param mixed[] $filters                                                     Datos de los filtros
*/
function lr_get_query_args_from_articles_filters($filters){
    $query_args = array();

    if( isset($filters['amount']) && $filters['amount'] !== null )
        $query_args['posts_per_page'] = $filters['amount'];

    if( isset($filters['suplements']) || isset($filters['sections']) || isset($filters['tags']) || isset($filters['authors']) ){
        $query_args['tax_query'] = rb_tax_query(array(
            // 'lr-article-suplement'  => isset($filters['suplements']) ? $filters['suplements'] : null,
            'ta_article_section'    => isset($filters['sections']) ? $filters['sections'] : null,
            'ta_article_tag'        => isset($filters['tags']) ? $filters['tags'] : null,
            'ta_article_author'     => isset($filters['authors']) ? $filters['authors'] : null,
        ));
    }

    return $query_args;
}


function get_ta_articles_block_articles($block_attributes){
    extract($block_attributes);
    $final_articles = null;

    if( $articles && is_array($articles) && !empty($articles) ){
        return $articles;
    }
    else if( $articles_data && is_array($articles_data) && !empty($articles_data) ){
        foreach($articles_data as $article_data){
            $final_articles[] = TA_Article_Factory::get_article($article_data['data'], $article_data['type']);
        }
    }
    else if( $most_recent ){
        $query_args = array(
            'post_type'	=> 'ta_article',
        );
        $query_args = array_merge(lr_get_query_args_from_articles_filters($block_attributes), $query_args);
        $final_articles = get_ta_articles_from_query($query_args);
    }

    return $final_articles;
}

function ta_is_term_articles_block($attributes){
    $has_unique_section = isset($attributes['sections']) && isset($attributes['sections']['terms']) && $attributes['sections']['terms'] && count($attributes['sections']['terms']) == 1 ? $attributes['sections']['terms'][0] : false;
    $has_unique_tag = isset($attributes['tags']) && isset($attributes['tags']['terms']) && $attributes['tags']['terms'] && count($attributes['tags']['terms']) == 1 ? $attributes['tags']['terms'][0] : false;
    $has_unique_author = isset($attributes['author']) && isset($attributes['author']['terms']) && $attributes['author']['terms'] && count($attributes['author']['terms']) == 1 ? $attributes['author']['terms'][0] : false;

    if($has_unique_section && !$has_unique_tag && !$has_unique_author)
        return TA_Section_Factory::get_section(get_term($has_unique_section, 'ta_article_section'));
    if($has_unique_tag && !$has_unique_author && !$has_unique_section)
        return TA_Tag_Factory::get_tag(get_term($has_unique_tag, 'ta_article_tag'));
    if($has_unique_author && !$has_unique_section && !$has_unique_tag)
        return TA_Author_Factory::get_author(get_term($has_unique_author, 'ta_article_author'));

    return false;
}

/**
*   Devuelve una taxonomies query a usar en un WP_Query de articulos, en base a los
*   siguientes parametros
*   @param array[] $terms                                   Array de terms tipo [ 'tax_id' => [124,626,34]]
*                                                           En vez de un array de terms, se puede pasar un array
*                                                           con mas opciones, las cuales se detallan a continuacion.
*           @param mixed[] $terms                           Terms de la taxonomia. Tienen que corresponder al valor pasado por
*                                                           la opcion 'field'
*           @param string $field                            Indica a que field del term se refieren los valores pasados por $terms
*                                                           Por default es 'term_id'
*           @param bool $required                           Indica si la query de la taxonomia es obligatoria. Esto mete a esta taxonomia
*                                                           en una query con relacion 'AND', junto a las demas taxonomias obligatorias.
*   @return mixed[]
*/
function rb_tax_query($terms){
    $final_query = array();
    $disjunct_query = array();
    $required_query = array();

    foreach($terms as $tax_name => $tax_data){
        $tax_terms = is_array($tax_data) && array_key_exists('terms', $tax_data) ? $tax_data['terms'] : $tax_data;

        if(!$tax_terms)
            continue;
        //Term tax query
        $tax_query = array(
            'taxonomy'  => $tax_name,
            'terms'     => $tax_terms,
            'field'     => is_array($tax_data) && isset($tax_data['field']) ? $tax_data['field'] : 'term_id',
        );
        if(isset($tax_data['required']) && $tax_data['required'])
            $required_query[] = $tax_query;
        else
            $disjunct_query[] = $tax_query;
    }

    if(!empty($required_query)){//If there are required terms
        $final_query = $required_query;
        $final_query['relation'] = 'AND';
    }

    if(!empty($disjunct_query)){
        $disjunct_query['relation'] = 'OR';
        if(empty($final_query))//if the query is empty (no required terms)
            $final_query = $disjunct_query;
        else
            $final_query[] = $disjunct_query;
    }

    return $final_query;
}

/**
*   @return null|mixed[]                                                        Array with the social data stablished through the customizer
*                                                                               control.
*/
function ta_get_social_data(){
    $data = get_theme_mod('ta-social-data', null);
    if($data){
        $data = array_map( function($social_data){
            $image = ta_get_social_image($social_data['name']);
            $social_data['image'] = $image;
            return $social_data;
        }, $data );
    }
    return $data;
}

/**
*   Return an image for the social contact if exists.
*   @param string $name
*   @return string|null                                                         Image URL
*/
function ta_get_social_image($name){
    $image = '';
    switch (strtolower( trim($name) )) {
        case 'facebook':
            $image = TA_THEME_URL . "/markup/assets/images/facebook-grey-icon.svg";
        break;
        case 'twitter':
            $image = TA_THEME_URL . "/markup/assets/images/twitter-grey-icon.svg";
        break;
        case 'spotify':
            $image = TA_THEME_URL . "/markup/assets/images/spotify-grey-icon.svg";
        break;
        case 'youtube':
            $image = TA_THEME_URL . "/markup/assets/images/youtube-grey-icon.svg";
        break;
        case 'instagram':
            $image = TA_THEME_URL . "/markup/assets/images/instagram-grey-icon.svg";
        break;
    }
    return $image;
}

function ta_is_featured_section($slug){
    switch($slug){
        case 'cultura':
            return true;
        break;
        case 'deportes':
            return true;
        break;
        case 'espectaculos':
            return true;
        break;
    }

    return false;
}

/**
 * Insert an attachment from an URL address.
 *
 * @param  String $url
 * @param  Int    $parent_post_id
 * @return Int    Attachment ID
 */
function crb_insert_attachment_from_url($url, $parent_post_id = null) {

	if( !class_exists( 'WP_Http' ) )
		include_once( ABSPATH . WPINC . '/class-http.php' );

	$http = new WP_Http();
	$response = $http->request( $url );

	if( is_wp_error($response) || $response['response']['code'] != 200 ) {
		return false;
	}

	$upload = wp_upload_bits( basename($url), null, $response['body'] );
	if( !empty( $upload['error'] ) ) {
		return false;
	}

	$file_path = $upload['file'];
	$file_name = basename( $file_path );
	$file_type = wp_check_filetype( $file_name, null );
	$attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
	$wp_upload_dir = wp_upload_dir();

	$post_info = array(
		'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
		'post_mime_type' => $file_type['type'],
		'post_title'     => $attachment_title,
		'post_content'   => '',
		'post_status'    => 'inherit',
	);

	// Create the attachment
	$attach_id = wp_insert_attachment( $post_info, $file_path, $parent_post_id );

	// Include image.php
	require_once( ABSPATH . 'wp-admin/includes/image.php' );

	// Define attachment metadata
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

	// Assign metadata to attachment
	wp_update_attachment_metadata( $attach_id,  $attach_data );

	return $attach_id;

}

function create_new_edicion_impresa($args){
    if(!$args || !is_array($args))
        return false;

    $default_args = array(
        'oldId'                                 => null,
        'printededition_date'                   => '',
        'printededition_issueyear'              => '',
        'printededition_issuenumber'            => '',
        'printededition_issuefile'              => '',
        'printededition_coversmall'             => '',
    );
    $args = array_merge($default_args, $args);
    extract($args);

    $issuefile_attachment_id = import_media( array( 'url' => $printededition_issuefile ) );
    $cover_attachment_id = import_media( array( 'url' => $printededition_coversmall ) );

    // if(!$issuefile_attachment_id || !$cover_attachment_id)
    //     return new WP_Error( 'attachment_upload_fail', __( "Ha habido un error al intentar crear los attachments necesarios para esta edicion impresa", "ta-theme" ) );

    $import_date = $printededition_date;
    $post_date = date("Y-m-d H:i:s", strtotime($import_date));

    $insert_result = wp_insert_post(array(
        'post_type'     => 'ta_ed_impresa',
        'post_title'    => $post_date,
        'post_date'     => $post_date,
        'post_status'   => 'publish',
        '_thumbnail_id' => $cover_attachment_id ? $cover_attachment_id : null,
        'meta_input'    => array(
            'oldId'                             => $oldId,
            'issueyear'                         => $printededition_issueyear,
            '_issuenumber'                      => $printededition_issuenumber,
            'issuefile_attachment_id'           => $issuefile_attachment_id ? $issuefile_attachment_id : null,
        ),
    ));

    return $insert_result; // WP_Error | 0 | post_id
}

function get_etiquetas($request){
	// init the resource
	$ch = curl_init();

	curl_setopt_array($ch, array(
		CURLOPT_URL               	=> "http://190.105.238.93:5000/api/textrank",
		CURLOPT_RETURNTRANSFER    	=> true,
		CURLOPT_POST				=> true,
		CURLOPT_HTTPHEADER			=> 'Content-Type: application/json',
		CURLOPT_POSTFIELDS			=> $request->get_body(),
	));

	// execute
	$output = curl_exec($ch);

	// free
	curl_close($ch);

	return $output;
}

function import_status_to_string($status_code){
    $status = 'draft';

    if( $status_code == 20 || $status_code == 21 || $status_code == 23 )
        $status = 'trash';
    else if( $status_code == 17 )
        $status = 'draft';
    else if( $status_code == 19 )
        $status = 'publish';

    return $status;
}

/**
*   @return WP_Post|null
*/
function get_edicion_impresa_by_date($date_string){
    $timestamp = strtotime($date_string);
    $date = $timestamp !== false ? getdate($timestamp) : null;

    if( !$date )
        return null;

    $query = new WP_Query( array(
        'post_type'     => 'ta_ed_impresa',
        'date_query'    => array(
            'year'          => $date['year'],
            'month'         => $date['mon'],
            'day'           => $date['mday'],
            'hour'          => $date['hours'],
            'minute'        => $date['minutes'],
            'second'        => $date['seconds'],
        ),
    ) );

    return $query && !is_wp_error($query) && $query->have_posts() ? $query->post : null;
}

/**
*   Returns the social meta value based on imported social data
*   @param mixed[] $social_data                                                 Imported social data for author/photographer
*   @return mixed[]
*/
function generate_author_social_meta($social_data){
    $social_meta = [];

    if( !isset($social_data) || !is_array($social_data) || empty($social_data) )
        return $social_meta;

    $twitter = isset($social_data['twitter']) ? $social_data['twitter'] : null;
    $instagram = isset($social_data['instagram']) ? $social_data['instagram'] : null;
    $email = isset($social_data['email']) ? $social_data['email'] : null;

    if( $twitter ){
        $social_meta['twitter'] = array(
            'name'      => 'Twitter',
            'url'       => isset($twitter['url']) ? $twitter['url'] : '',
            'username'  => isset($twitter['user']) ? $twitter['user'] : '',
        );
    }

    if( $instagram ){
        $social_meta['instagram'] = array(
            'name'      => 'Instagram',
            'url'       => isset($instagram['url']) ? $instagram['url'] : '',
            'username'  => isset($instagram['user']) ? $instagram['user'] : '',
        );
    }

    if( $email ){
        $social_meta['email'] = array(
            'name'      => 'Email',
            'username'  => $email,
        );
    }

    return $social_meta;
}

/**
*   @return WP_Error|WP_Term|null
*/
function get_or_create_photographer($photographer_data){
    if( !$photographer_data || !is_array($photographer_data) || !isset($photographer_data['name']) )
        return null;

    // Photographer already exists
    $photographer =  get_term_by('name', $photographer_data['name'], 'ta_photographer');
    if( $photographer )
        return $photographer;

    $photographer_creation = wp_insert_term($photographer_data['name'], 'ta_photographer');
    // New term fail
    if( !$photographer_creation || is_wp_error($photographer_creation) )
        return $photographer_creation;

    $photographer = get_term($photographer_creation['term_id'], 'ta_photographer');
    // Get term fail
    if( !$photographer || is_wp_error($photographer) )
        return $photographer;

    // Add socials metadata
    $social_meta = isset($photographer_data['social']) ? generate_author_social_meta( $photographer_data['social'] ) : null;
    if($social_meta && !empty($social_meta))
        add_term_meta( $photographer->term_id, 'ta_photographer_networks', $social_meta, true );

    return $photographer;
}

/**
*   @return WP_Error|WP_Term|null
*/
function get_or_create_author($author_data){
    if( !$author_data || !is_array($author_data) || !isset($author_data['name']) )
        return null;

    // Author already exists
    $author =  get_term_by('name', $author_data['name'], 'ta_article_author');
    if( $author )
        return $author;

    $author_creation = wp_insert_term($author_data['name'], 'ta_article_author');
    // New term fail
    if( !$author_creation || is_wp_error($author_creation) )
        return $author_creation;

    $author = get_term($author_creation['term_id'], 'ta_article_author');
    // Get term fail
    if( !$author || is_wp_error($author) )
        return $author;

    // Add socials metadata
    $social_meta = isset($author_data['social']) ? generate_author_social_meta( $author_data['social'] ) : null;
    if($social_meta && !empty($social_meta))
        add_term_meta( $author->term_id, 'ta_author_networks', $social_meta, true );

    return $author;
}

function get_attachments($query_args){
    $query = new WP_Query( array_merge(
        $query_args,
        array(
            'post_type'     => 'attachment',
            'post_status'   => 'inherit',
        ),
    ) );

    return $query && !is_wp_error($query) && $query->have_posts() ? $query->posts : [];
}

/**
*   Returns the attachment post of an imported media by its old url
*   @param string $old_url                                                      URL from the old site
*/
function get_imported_attachment_by_old_url($old_url){
    $attachments = get_attachments(array(
        'posts_per_page'    => 1,
        'page'              => 1,
        'meta_key'         	=> 'old_url',
        'meta_value'       	=> $old_url,
    ));

    return $attachments ? $attachments[0] : null;
}

/**
*   @return int|WP_Error|false
*/
function import_media($media_data){
    if( !is_array($media_data) || !isset($media_data['url']) )
        return null;

    // Check if it has already been uploaded
    $attachment = get_imported_attachment_by_old_url($media_data['url']);
    if($attachment){
        return $attachment->ID;
    }

    // Create new attachment
    $attachment_id = crb_insert_attachment_from_url($media_data['url']);

    // Return fail
    if( !$attachment_id || is_wp_error($attachment_id) )
        return $attachment_id;

    $attachment_data = array(
        'ID'                => $attachment_id,
        'tax_input'         => array(),
        'meta_input'        => array(
            'old_url'               => $media_data['url'],
        ),
    );

    // Attachment title
    if( isset($media_data['name']) )
        $attachment_data['post_title'] = $media_data['name'];

    // Photographer
    $photographer = isset($media_data['author']) ? get_or_create_photographer($media_data['author']) : null;

    if( $photographer && !is_wp_error($photographer) )
        $attachment_data['tax_input']['ta_photographer'] = [$photographer->term_id];

    // Update with final data
    wp_update_post($attachment_data);

    return $attachment_id;
}

/**
*   @param string[] $tags
*   @return int[]
*/
function get_or_create_tags($tags){
    $tags_ids = [];
    if(!is_array($tags))
        return $tags_ids;

    foreach($tags as $tag_name){
        $term = get_term_by('name', $tag_name, 'ta_article_tag');
        if(!$term){
            $new_term_data = wp_insert_term( $tag_name, 'ta_article_tag');
            $term = !is_wp_error($new_term_data) ? get_term($new_term_data['term_id'], 'ta_article_tag') : null;
        }
        if($term && !is_wp_error($term))
            $tags_ids[] = $term->term_id;
    }

    return $tags_ids;
}

/**
*   Uploads and returns attachments ids for a gallery
*/
function create_gallery($gallery_items){
    $items_ids = [];
    if( is_array($gallery_items) && !empty($gallery_items) ){
        foreach($gallery_items as $gallery_item){
            $attachment_id = import_media($gallery_item);
            if($attachment_id && !is_wp_error($attachment_id))
                $items_ids[] = $attachment_id;
        }
    }
    return $items_ids;
}

/**
*   Return the post type of a new imported article based on the import arguments
*   @return string
*/
function get_import_article_post_type($args){
    $post_type = 'ta_article';
    if(isset($args['isaudiovisual']) && $args['isaudiovisual'])
        $post_type = 'ta_audiovisual';
    else if( isset($args['isphotogallery']) && is_array($args['isphotogallery']) && !empty($args['isphotogallery']) )
        $post_type = 'ta_fotogaleria';
    return $post_type;
}

function generate_article_authors($authors_data){
    $authors_result = array(
        'authors'       => array(),
        'rols'         => array(),
    );

    if(!$authors_data || !is_array($authors_data) || empty($authors_data))
        return $authors_result;

    foreach ($authors_data as $author_data) {
        $author_term = get_or_create_author($author_data);
        if(!$author_term || is_wp_error($author_term))
            continue;
        // Author id
        $authors_result['authors'][] = $author_term->term_id;
        // Rol
        if( isset($author_data['rol']) && $author_data['rol'])
            $authors_result['rols'][$author_term->term_id] = $author_data['rol'];
    }

    return $authors_result;
}

function create_new_article($args){
    if(!$args || !is_array($args))
        return false;

    $default_args = array(
        'post_author'                                   => null,
        'oldId'                                         => null,    // Done
        'publicslug'                                    => null,    // Done - Saved as meta, ok?
        'headline'                                      => null,    // Done
        'section'                                       => null,    // Done
        'leadtext'                                      => null,    // Done
        'publicreleasedate'                             => null,    // Done
        'coverimage'                                    => null,    // Done
        'mainpicture'                                   => null,    // Done
        'autores'                                       => null,    // Done
        'articlebody'                                   => null,    // Done
        'articlekeywords'                               => null,    // Done
        'status'                                        => null,    // Done
        'isopinion'                                     => null,    // Done
        'isaudiovisual'                                 => null,    // Done - Video url missing
        'printededition_date'                           => null,    // Done
        'microsite'                                     => null,    // Done
        'isphotogallery'                                => null,    // Done
    );
    $args = array_merge($default_args, $args);
    extract($args);

    $coverimage_attachment_id = import_media($coverimage);
    $mainpicture_attachment_id = import_media($mainpicture);
    $section_term = $section ? get_term_by('slug', $section, 'ta_article_section') : null;
    $micrositio_term = $microsite ? get_term_by('slug', $microsite, 'ta_article_micrositio') : null;
    $edicion_impresa_post = $printededition_date ? get_edicion_impresa_by_date($printededition_date) : null;
    // if(!$issuefile_attachment_id || !$cover_attachment_id)
    //     return new WP_Error( 'attachment_upload_fail', __( "Ha habido un error al intentar crear los attachments necesarios para esta edicion impresa", "ta-theme" ) );

    $import_date = $publicreleasedate;
    $post_date = date("Y-m-d H:i:s", strtotime($import_date));
    $post_type = get_import_article_post_type($args);
    $authors_creation = generate_article_authors($autores);

    $insert_result = wp_insert_post(array(
        'post_type'     => $post_type,
        'post_date'     => $post_date,
        'post_title'    => $headline,
        'post_excerpt'  => wp_strip_all_tags($leadtext),
        'post_content'  => "<!-- wp:html -->$articlebody<!-- /wp:html -->",
        'post_status'   => import_status_to_string($status),
        'post_author'   => $post_author,
        '_thumbnail_id' => $mainpicture_attachment_id ? $mainpicture_attachment_id : null,
        'tax_input'     => array(
            'ta_article_author'     => !empty($authors_creation['authors']) ? $authors_creation['authors'] : [],
            'ta_article_section'    => $section_term ? [$section_term->term_id] : [],
            'ta_article_tag'        => get_or_create_tags($articlekeywords),
            'ta_article_micrositio' => $micrositio_term ? [$micrositio_term->term_id] : [],
        ),
        'meta_input'    => array(
            'oldId'                             => $oldId,
            'ta_article_isopinion'              => $isopinion,
            'ta_article_thumbnail_alt'          => $coverimage_attachment_id,
            'ta_article_edicion_impresa'        => $edicion_impresa_post ? $edicion_impresa_post->ID : null,
            'ta_article_gallery'                => $post_type == 'ta_fotogaleria' ? create_gallery($isphotogallery) : null,
            'ta_article_authors_rols'           => !empty($authors_creation['rols']) ? $authors_creation['rols'] : [],
            'publicslug'                        => $publicslug,
        ),
    ));

    return $insert_result; // WP_Error | 0 | post_id
}


/**
*   Returns the photographer of an attachment
*   @param int $attachment_id
*   @return TA_Photographer|null
*/
function ta_get_attachment_photographer($attachment_id){
    $photographer_terms = get_the_terms($attachment_id, 'ta_photographer');
    if( !$photographer_terms || is_wp_error($photographer_terms) || empty($photographer_terms) )
        return null;
    return TA_Photographer::get_photographer($photographer_terms[0]->term_id);
}

function rb_get_or_create_term($name, $taxonomy){
    // Already exists
    $term = get_term_by('name', $name, $taxonomy);
    if( $term )
        return $term;

    $term_creation = wp_insert_term($name, $taxonomy);
    // New term fail
    if( !$term_creation || is_wp_error($term_creation) )
        return $term_creation;

    $term = get_term($term_creation['term_id'], $taxonomy);
    // Get term fail
    if( !$term || is_wp_error($term) )
        return $term;

    return $term;
}

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

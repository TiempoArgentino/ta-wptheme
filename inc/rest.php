<?php

// "oldId": "",
// "printededition_date": "Sat 16 Jan 2016 00:00:00",
// "printededition_issueyear": "6",
// "printededition_issuenumber": "2043",
// "printededition_issuefile": "https://www.tiempoar.com.ar/assets/files/editions/old/pdf/2043.pdf",
// "printededition_coversmall": "https://www.tiempoar.com.ar/assets/files/editions/old/portada/2043.jpg"


// New Edicion Impresa
add_action( 'rest_api_init', function () {

	register_rest_route( 'ta/v1', '/edicion-impresa', array(
		'methods' 				=> 'POST',
		'callback' 				=> function($request){
            $args = $request->get_json_params();

			// Check if this article has been uploaded based on oldId
			// $oldId = isset($args['oldId']) ? $args['oldId'] : $args['oldId'];
			// $query = new WP_Query(array(
			// 	'post_type'			=> 'ta_ed_impresa',
			//    	'meta_key'         	=> 'oldId',
		    //    	'meta_value'       	=> $oldId,
			// ));
			//
			// if( $query->have_posts() )
			// 	return new WP_REST_Response('Ya existe una edicion impresa con dicha ID', 500);

			$ed_impresa_id = create_new_edicion_impresa($args);

            if( is_wp_error($ed_impresa_id) )
                return new WP_REST_Response($ed_impresa_id->get_error_message(), 500);

			if( $ed_impresa_id === false )
				return new WP_REST_Response('Ha habido un error al intentar crear la edicion impresa', 500);

			return new WP_REST_Response($ed_impresa_id, 200);
		},
		'permission_callback' => function () {
	    	return current_user_can( 'edit_others_posts' );
	    },
	) );


	register_rest_route( 'ta/v1', '/import/article', array(
		'methods' 				=> 'POST',
		'callback' 				=> function($request){
			$args = $request->get_json_params();

			// Check if this article has been uploaded based on oldId
			// $oldId = isset($args['oldId']) ? $args['oldId'] : $args['oldId'];
			// $query = new WP_Query(array(
			// 	'post_type'			=> 'ta_article',
			// 	'meta_key'         	=> 'oldId',
			// 	'meta_value'       	=> $oldId,
			// ));
			// if( $query->have_posts() )
			// 	return new WP_REST_Response('Ya existe una edicion impresa con dicha ID', 500);

			$article_id = create_new_article($args);

			if( is_wp_error($article_id) )
				return new WP_REST_Response($article_id->get_error_message(), 500);

			if( $article_id === false )
				return new WP_REST_Response('Ha habido un error al intentar crear el articulo', 500);

			return new WP_REST_Response($article_id, 200);
		},
		'permission_callback' => function () {
			return current_user_can( 'edit_others_posts' );
		},
	) );


    // Update post meta
	register_rest_route( 'ta/v1', '/post/meta', array(
		'methods' 				=> 'POST',
		'callback' 				=> function($request){
			$params = $request->get_body_params();
			$meta_key = isset($params['meta']) ? $params['meta'] : null;
			$meta_value = isset($params['value']) ? $params['value'] : null;
            $post_id = isset($params['postID']) ? $params['postID'] : null;

			$response = new WP_REST_Response(update_post_meta( $post_id, $meta_key, $meta_value ), 200);
			return $response;
		},
		'permission_callback' => function () {
	    	return current_user_can( 'edit_others_posts' );
	    },
	) );

    register_rest_route('ta/v1', '/etiquetador', array(
        'methods' 				=> 'POST',
        'callback' 				=> 'get_etiquetas',
        'permission_callback'	=> '__return_true',
    ) );

    register_rest_route( 'ta/v1', '/articles', array(
        'methods' 				=> 'POST',
        'callback' 				=> function($request){
            $params = $request->get_json_params();
            $articles = [];
            $result = rb_get_posts($params['args']);
            $posts = $result['posts'];
            $query = $result['wp_query'];

            if($posts && !empty($posts)){
                foreach ($posts as $article_post) {
                    $article = TA_Article_Factory::get_article($article_post, 'article_post');
                    $article->populate(true);
                    $articles[] = $article;
                }
            }

            $response = new WP_REST_Response($articles, 200);
            $response->header('X-WP-TotalPages', $result['total_pages']);
            return $response;
        },
        'permission_callback'	=> '__return_true',
    ) );

} );

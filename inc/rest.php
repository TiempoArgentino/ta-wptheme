<?php

// "oldId": "",
// "printededition_date": "Sat 16 Jan 2016 00:00:00",
// "printededition_issueyear": "6",
// "printededition_issuenumber": "2043",
// "printededition_issuefile": "https://www.tiempoar.com.ar/assets/files/editions/old/pdf/2043.pdf",
// "printededition_coversmall": "https://www.tiempoar.com.ar/assets/files/editions/old/portada/2043.jpg"


// New Edicion Impresa
add_action( 'rest_api_init', function () {

	register_rest_route( 'ta/v1', '/balancer-db/load-latest', array(
		'methods' 				=> 'POST',
		'callback' 				=> function($request){
			$params = $request->get_json_params();
			$days_ago = isset($params['days']) && is_int($params['days']) ? $params['days'] : null;
			return new WP_REST_Response(TA_Balancer_DB::insert_latest_articles($days_ago), 200);
		},
		'permission_callback' 	=> fn() => current_user_can( 'delete_published_articles' ),
	) );

	register_rest_route( 'ta/v1', '/balancer-db/articles', array(
		'methods' 				=> 'POST',
		'callback' 				=> function($request){

			// init the resource
			$ch = curl_init("https://content-balancer-tiempoar.herokuapp.com/api/posts");
			curl_setopt($ch, CURLOPT_URL, "https://content-balancer-tiempoar.herokuapp.com/api/posts");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CAINFO, TA_THEME_PATH . '/inc/cacert.pem');

			// Check if initialization had gone wrong*
		    if ($ch === false) {
				return new WP_REST_Response( 'Failed to initialize', 500);
		    }

			// execute
			$output = curl_exec($ch);
			if ($output === false) {
				throw new Exception(curl_error($ch), curl_errno($ch));
				// return new WP_REST_Response( 'Failed to initialize', 500);
		    }
			// free
			curl_close($ch);

			$articles = json_decode($output);

			return new WP_REST_Response(array(
				'articles'	=> $articles,
			), 200);
		},
		'permission_callback' => function () {
	    	return true;
	    },
	) );

	register_rest_route( 'ta/v1', '/balancer-row', array(
		'methods' 				=> 'POST',
		'callback' 				=> function($request){
			$params = $request->get_json_params();
			$articles_db = isset($params['articles']) ? $params['articles'] : [];
			$row_args = isset($params['row_args']) ? $params['row_args'] : [];

			if(!is_array($articles_db) || !is_array($articles_db)){
				return new WP_REST_Response(array(
					'html'	=> '',
				), 200);
			}

			$row_args['use_balacer_articles'] = false;

			$articles = array_map( fn($article_db) => new TA_Balancer_Article($article_db), $articles_db);

			ob_start();
			ta_render_articles_block_row($articles, $row_args, 0);
			$row = ob_get_clean();

			return new WP_REST_Response(array(
				'html'	=> $row,
			), 200);
		},
		'permission_callback' => function () {
	    	return true;
	    },
	) );

	register_rest_route( 'ta/v1', '/comment', array(
		'methods' 				=> 'POST',
		'callback' 				=> function($request){
            $args = $request->get_json_params();
			$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );

		    if ( is_wp_error( $comment ) ) {
				$error_data = intval( $comment->get_error_data() );
				if ( ! empty( $error_data ) ) {
					return new WP_REST_Response($comment->get_error_message(), 400);
				} else {
					return new WP_REST_Response( 'Error desconocido.', 400);
				}
			}

			ob_start();
			get_template_part('parts/comments', 'single_thread', array( 'comment' => $comment ));
			$template = ob_get_clean();


			return new WP_REST_Response(array(
				'total_amount'	=> get_comments_number($_POST['comment_post_ID']),
				'comment'		=> $comment,
				'template'		=> $template,
			), 200);
		},
		'permission_callback' => function () {
	    	return true;
	    },
	) );

	register_rest_route( 'ta/v1', '/template/comments', array(
		'methods' 				=> 'POST',
		'callback' 				=> function($request){
            $args = $request->get_json_params();

			if(!is_array($args) || !isset($args['post_id']))
				return new WP_REST_Response('', 200);

			if(get_current_user_id()){
				$args['author__not_in'] = [get_current_user_id()];
			}

			ob_start();
			get_template_part('parts/article', 'comments', $args);
			$template = ob_get_clean();

			return new WP_REST_Response(array(
				'total_amount'	=> get_comments_number($args['post_id']),
				'template'		=> $template,
			), 200);
		},
		'permission_callback' => function () {
	    	return true;
	    },
	) );

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
	    	return current_user_can( 'edit_eds_impresas' );
	    },
	) );

	register_rest_route( 'ta/v1', '/import/delete-duplicated-trash', array(
		'methods' 				=> 'POST',
		'callback' 				=> function($request){
			global $wpdb;

			$results = $wpdb->get_results( "
				SELECT p1.post_title, p1.ID
					FROM $wpdb->posts p1
					JOIN (
						SELECT *, COUNT(*)
						FROM $wpdb->posts
						WHERE
							post_status = 'trash'
							AND (
								post_type = 'ta_article'
								OR post_type = 'ta_audiovisual'
								OR post_type = 'ta_fotogaleria'
							)
						GROUP BY post_title
						HAVING count(*) > 1
					) p2
						ON p1.post_status = p2.post_status
						AND p1.post_type = p2.post_type
						AND p1.post_title = p2.post_title
					ORDER BY p1.post_title
			");
			//w3cp_posts

			if(is_wp_error($results))
				return new WP_REST_Response($ids, 500);

			$ids = [];
			if(is_array($results) && !empty($results)){
				$duplicated_amount = count($results) - 1;
				for ($i=0; $i < $duplicated_amount; $i++) {
					$post_data = $results[$i];
					if(wp_delete_post( (int) $post_data->ID, $force_delete = true ))
						$ids[] = (int) $post_data->ID;
				}
			}

			return new WP_REST_Response($ids, 200);
		},
		'permission_callback' => function () {
			return current_user_can( 'delete_published_articles' );
		},
	) );

	register_rest_route( 'ta/v1', '/import/article', array(
		'methods' 				=> 'POST',
		'callback' 				=> function($request){
			$args = $request->get_json_params();

			// Check if this article has been uploaded based on oldId
			$oldId = isset($args['oldId']) ? $args['oldId'] : $args['oldId'];
			if(!$oldId)
				return new WP_REST_Response('No se paso un oldId', 500);

			$query = new WP_Query(array(
				'post_type'			=> ['ta_article', 'ta_audiovisual', 'ta_fotogaleria'],
				'post_status' 		=> array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
				'meta_key'         	=> 'oldId',
				'meta_value'       	=> $oldId,
			));
			if( $query->have_posts() )
				return new WP_REST_Response('Ya existe un articulo con la oldId pasada', 409);

			// Try to create a new post
			$article_id = create_new_article(array_merge($args, array( 'post_author' => 5 )));

			if( is_wp_error($article_id) )
				return new WP_REST_Response($article_id->get_error_message(), 500);

			if( !$article_id )
				return new WP_REST_Response('Ha habido un error al intentar crear el articulo', 500);

			return new WP_REST_Response($article_id, 200);
		},
		'permission_callback' => function () {
			return current_user_can( 'edit_published_articles' );
		},
	) );

	register_rest_route( 'ta/v1', '/import/fix-articles-images', array(
		'methods' 				=> 'POST',
		'callback' 				=> function($request){
			$args = $request->get_json_params();

			$update_result = correct_article_images(array_merge($args, array( 'post_author' => 5 )));

			if( is_wp_error($update_result) )
				return new WP_REST_Response($update_result->get_error_message(), 500);

			if( !$update_result )
				return new WP_REST_Response('No se encontró un artículo con ese oldId, o se encontró pero las urls pasadas no estaban vacías.', 500);

			return new WP_REST_Response($update_result, 200);
		},
		'permission_callback' => function () {
			return current_user_can( 'edit_published_articles' );
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
		'permission_callback' => function ($request) {
			$params = $request->get_body_params();
			$post_id = isset($params['postID']) ? $params['postID'] : null;
			if(!$post_id)
				return false;
	    	return current_user_can( 'edit_post', $post_id );
	    },
	) );

    register_rest_route('ta/v1', '/etiquetador', array(
        'methods' 				=> 'POST',
        'callback' 				=> 'get_etiquetas',
		'permission_callback' 	=> function ($request) {
	    	return current_user_can( 'edit_articles' );
	    },
    ) );

    register_rest_route( 'ta/v1', '/articles', array(
        'methods' 				=> 'POST',
        'callback' 				=> function($request){
            $params = $request->get_json_params();
            $articles = [];
			// $default_options = array(
			// 	'populate'	=> false,
			// );
            $result = rb_get_posts($params['args']);
            $posts = $result['posts'];
            $query = $result['wp_query'];

            if($posts && !empty($posts)){
                foreach ($posts as $article_post) {
                    $article = TA_Article_Factory::get_article($article_post, 'article_post');
					if($article){
						$article_scheme = array(
							'ID'				=> $article->ID,
							'title'				=> $article->title,
							'excerpt'			=> $article->excerpt,
							'thumbnail_common'	=> $article->thumbnail_common,
							'date'				=> $article->date,
							'isopinion'			=> $article->isopinion,
							'cintillo'			=> $article->cintillo,
							'first_author'		=> $article->first_author,
						);

						$article_scheme['authors'] = $article->authors ? array_map( function($author){
							return array(
								'ID'				=> $author->ID,
								'name'				=> $author->name,
								'photo'				=> $author->photo,
								'has_photo'			=> $author->has_photo,
							);
						}, $article->authors ) : null;

						$article_scheme['first_author'] = $article->first_author ? array(
							'ID'				=> $article->first_author->ID,
							'name'				=> $article->first_author->name,
							'photo'				=> $article->first_author->photo,
							'has_photo'			=> $article->first_author->has_photo,
						) : null;

						// $article_scheme['section'] = $article->section ? array(
						// 	'name'			=> $article->section->name,
						// 	'slug'			=> $article->section->slug,
						// 	'archive_url'	=> $article->section->archive_url,
						// ) : null;
						//
						// $article_scheme['micrositio'] = $article->micrositio ? array(
						// 	'title'			=> $article->micrositio->title,
						// 	'slug'			=> $article->micrositio->slug,
						// ) : null;

						// $article->populate(true);
						$articles[] = $article_scheme;
					}
                }
            }

            $response = new WP_REST_Response($articles, 200);
            $response->header('X-WP-TotalPages', $result['total_pages']);
            return $response;
        },
        'permission_callback'	=> '__return_true',
    ) );

	register_rest_route( 'ta/v1', '/authors', array(
        'methods' 				=> 'POST',
        'callback' 				=> function($request){
            $params = $request->get_json_params();
			$param_args = isset($params['args']) && is_array($params['args']) ? $params['args'] : [];
            $authors = [];
            $query_args = array_merge(
				array(
					'taxonomy' => 'ta_article_author',
				),
				$param_args,
			);
			$query = new WP_Term_Query($query_args);
			$author_terms = $query && !is_wp_error($query) ? $query->get_terms() : null;

            if($author_terms && !empty($author_terms)){
                foreach ($author_terms as $author_term) {
                    $author = TA_Author_Factory::get_author($author_term, 'article_author_term');
					if($author){
						// $author->populate(true);
						$authors[] = array(
							'ID'				=> $author->ID,
							'name'				=> $author->name,
							'photo'				=> $author->photo,
							'has_photo'			=> $author->has_photo,
						);
					}
                }
            }

            $response = new WP_REST_Response($authors, 200);
            // $response->header('X-WP-TotalPages', $result['total_pages']);
            return $response;
        },
        'permission_callback'	=> '__return_true',
    ) );

	register_rest_route( 'ta/v1', '/photographers', array(
        'methods' 				=> 'POST',
        'callback' 				=> function($request){
            $params = $request->get_json_params();
			$param_args = isset($params['queryArgs']) && is_array($params['queryArgs']) ? $params['queryArgs'] : [];
            $authors = [];
            $query_args = array_merge(
				array(
					'taxonomy' => 'ta_photographer',
				),
				$param_args,
			);
			$query = new WP_Term_Query($query_args);
			$author_terms = $query && !is_wp_error($query) ? $query->get_terms() : null;

            if($author_terms && !empty($author_terms)){
                foreach ($author_terms as $author_term) {
                    $author = TA_Photographer::get_photographer($author_term->term_id);
					if($author){
						$authors[] = array(
							'ID'			=> $author->ID,
							'name'			=> $author->name,
							'is_from_ta'	=> $author->is_from_ta,
						);
					}
                }
            }

            $response = new WP_REST_Response($authors, 200);
            // $response->header('X-WP-TotalPages', $result['total_pages']);
            return $response;
        },
        'permission_callback'	=> '__return_true',
    ) );

	// register_rest_route( 'ta/v1', '/podcast-block', array(
    //     'methods' 				=> 'POST',
    //     'callback' 				=> function($request){
    //         $params = $request->get_json_params();
	// 		$podcast_data = isset($params['args']) && is_array($params['args']) ? $params['args'] : [];
    //         $authors = [];
    //         $query_args = array_merge(
	// 			array(
	// 				'taxonomy' => 'ta_photographer',
	// 			),
	// 			$param_args,
	// 		);
	// 		$query = new WP_Term_Query($query_args);
	// 		$author_terms = $query && !is_wp_error($query) ? $query->get_terms() : null;
	//
    //         if($author_terms && !empty($author_terms)){
    //             foreach ($author_terms as $author_term) {
    //                 $author = TA_Photographer::get_photographer($author_term->term_id);
	// 				if($author){
	// 					$author->populate(true);
	// 					$authors[] = $author;
	// 				}
    //             }
    //         }
	//
    //         $response = new WP_REST_Response($authors, 200);
    //         // $response->header('X-WP-TotalPages', $result['total_pages']);
    //         return $response;
    //     },
    //     'permission_callback'	=> '__return_true',
    // ) );
} );

<?php

/**
*   Class in charge of communicating the wordpress DB with the balancer mongoose DB
*/
class TA_Balancer_DB{
	static private $initialized = false;

    /**
    *   @property string $api_url
	*	It gets stablished during initialize() based on the current envirionment.
    */
    static private $api_url = '';

    /**
    *   @property string[] $metakeys
    *   Contains the metakeys (array keys) that should be present in an article from
    *   the DB. The value of the key is name of the field it occupies on the articles document
    */
    static private $metakeys = array(
        'ta_article_cintillo'   => 'headband',
        'ta_article_isopinion'  => 'isOpinion',
        '_thumbnail_id' => 'imgURL'
    );

	static public function initialize(){
		if(self::$initialized)
			return false;

		 self::$initialized = true;

		 if(!defined('TA_BALANCER_API_URI') || !defined('TA_BALANCER_API_KEY'))
		 	return false;

		 self::stablish_env_variables();
		 self::sync_latest_articles_with_balancer_db();
		 self::sync_terms_with_balancer_db();
	}

	static private function stablish_env_variables(){
		self::$api_url = TA_BALANCER_API_URI;
	}

	static private function get_api_key_header(){
		return 'api-key: ' . TA_BALANCER_API_KEY;
	}

    /**
    *   Composes an endpoint for the api using the stored api base url
    *   @param string $route
    */
    static public function get_api_endpoint(string $route = ""){
        return self::$api_url . $route;
    }

    /**
    *   Returns the authors data with the scheme used in the balancer DB
    *   @param TA_Author_Data $author
    */
    static public function get_author_data($author){
        return $author ? array(
            'authorId'			=> $author->ID,
            'authorName'		=> $author->name,
            'authorUrl'			=> $author->archive_url,
            'authorImg'			=> $author->photo,
        ) : null;
    }

    /**
    *   Returns the article data with the scheme used in the balancer DB
    *   @param TA_Article_Data $article
    *   @param string[] $wanted_fields                                          Fields wanted from the article
    */
    static public function get_article_data($article, $wanted_fields = null){
        if(!$article)
            return null;

        $scheme = array(
            'postId'			=> fn($article) => $article->ID,
            'title'				=> fn($article) => $article->title,
            'url'				=> fn($article) => $article->url,
            'headband'			=> fn($article) => $article->cintillo,
            'imgURL'			=> function($article){
                $thumbnail = $article->thumbnail_alt_common ? $article->thumbnail_alt_common : $article->thumbnail_common;
                $thumbnail_url = $thumbnail ? $thumbnail['url'] : '';
                return $thumbnail_url;
            },
            'isOpinion'			=> fn($article) => $article->isopinion,
            'section'			=> fn($article) => $article->section ? $article->section->ID : null,
            'authors'			=> fn($article) => $article->authors ? array_map( [self::class, 'get_author_data'], $article->authors ) : [],
            'tags'				=> fn($article) => $article->tags ? array_map( fn($tag) => array( 'tagId' => $tag->ID ), $article->tags ) : [],
            'themes'			=> fn($article) => $article->temas ? array_map( fn($tema) => array( 'themeId' => $tema->term_id ), $article->temas ) : [],
            'places'			=> fn($article) => $places = $article->lugares ? array_map( fn($lugar) => array( 'placeId' => $lugar->term_id ), $article->lugares ) : [],
        );
        $wanted_fields = is_array($wanted_fields) ? array_merge($wanted_fields, ['postId']) : array_keys($scheme);
        $data = array();

        foreach ($wanted_fields as $scheme_field_name)
            if( $scheme[$scheme_field_name] ?? false )
                $data[$scheme_field_name] = call_user_func($scheme[$scheme_field_name], $article);

        return $data;
    }

    /**
    *   Indicates if a given post is supposed to be in the DB
    *   @param WP_Post|int|null $post                                           The wordpress post to check
    *   @return bool
    */
    static public function post_is_db_compatible($post){
        $post = get_post($post);
        if(!$post)
            return false;
        // Article from the last 20 days
        return $post->post_type == 'ta_article' && (strtotime( $post->post_date ) > strtotime('-20 days'));
    }

    /**
    *   Indicates if a given meta is supposed to be in an article in the DB
    *   @param string $meta_key
    *   @return bool
    */
    static public function meta_is_db_compatible($meta_key){
        return isset(self::$metakeys[$meta_key]);
    }

    /**
    *   Hooks DB update callbacks to wordpress articles and metadata updates actions
    */
	static private function sync_latest_articles_with_balancer_db(){

        // Status change
        RB_Filters_Manager::add_action( "ta_latest_articles_sync", "transition_post_status", function($new_status, $old_status, $post){
			// Not an article, or older than 20 days
			if(!self::post_is_db_compatible($post))
				return;

			// no previous status or new status publish
			if ( $new_status == 'new' || $new_status == 'publish' ){
				TA_Article_Factory::$use_cache = false;
                self::create_or_update_article( self::get_article_data( TA_Article_Factory::get_article($post) ) );
				TA_Article_Factory::$use_cache = true;
			}
			else if ( $old_status == 'publish' ) // from published to something else
                self::delete_article($post->ID);
		}, array(
			'priority'		=> 100,
			'accepted_args'	=> 3,
		) );
        
         // First upload of meta data (if no exists).
         RB_Filters_Manager::add_action("ta_latest_articles_sync_add_meta", "add_post_meta", function($post_id, $meta_key, $meta_value){
            if( !self::post_is_db_compatible($post_id) || !self::meta_is_db_compatible($meta_key) )// post or meta not compatible
                return;
                
            TA_Article_Factory::$use_cache = false;
			$article_data = self::get_article_data( TA_Article_Factory::get_article($post_id), array(self::$metakeys[$meta_key]) );
			$article_data["imgURL"] = wp_get_attachment_image_url($meta_value, 'full', false);
            self::create_or_update_article( $article_data );
            TA_Article_Factory::$use_cache = true;
        }, array(
            'priority'		=> 100,
            'accepted_args'	=> 3,
        ));

        // Some metadata gets updated after a post save hook.
        RB_Filters_Manager::add_action("ta_latest_articles_sync_metas", "updated_post_meta", function($meta_id, $post_id, $meta_key, $meta_value){
            if( !self::post_is_db_compatible($post_id) || !self::meta_is_db_compatible($meta_key) )// post or meta not compatible
                return;

            // we removed the cache to avoid grabbing old values stored before meta_update
            // We don't use $meta_value directly because it may need some proccesing from the TA_Article, like with ta_article_isopinion
            TA_Article_Factory::$use_cache = false;
            self::create_or_update_article( self::get_article_data( TA_Article_Factory::get_article($post_id), array(self::$metakeys[$meta_key]) ) );
            TA_Article_Factory::$use_cache = true;
        }, array(
            'priority'		=> 100,
            'accepted_args'	=> 4,
        ));

        // Deletion
        RB_Filters_Manager::add_action( "ta_latest_articles_deletion_sync", "delete_post", function($postid, $post){
            if(self::post_is_db_compatible($post))
                self::delete_article($postid);
        }, array(
            'priority'		=> 100,
            'accepted_args'	=> 2,
        ) );
	}

    /**
    *   Hooks DB update callbacks to wordpress terms update actions. If a term is
    *   in any of the latest articles, it updates the DB.
    */
	static private function sync_terms_with_balancer_db(){
		$taxonomies = [
			'ta_article_tag'	=> 'tags',
			'ta_article_author'	=> 'authors',
			'ta_article_tema'	=> 'themes',
			'ta_article_place'	=> 'places',
		];

		// TODO: $object_ids contiene los ids de los articulos con los que se relaciona. Se podria pasar al request si facilita la busqueda en la db
		RB_Filters_Manager::add_action( "ta_delte_terms_in_balancer_db", "delete_term", function($term_id, $tt_id, $taxonomy, $deleted_term, $object_ids) use ($taxonomies){
			if( !array_key_exists($taxonomy, $taxonomies) )
				return;

			self::delete_term($term_id, $taxonomies[$taxonomy]);
		}, array(
			'priority'		=> 100,
			'accepted_args'	=> 5,
		) );

		RB_Filters_Manager::add_action( "ta_update_authors_in_balancer_db", "edited_term", function($term_id, $tt_id, $taxonomy){
			if( $taxonomy !== 'ta_article_author' )
				return;

			self::update_author( self::get_author_data(TA_Author_Factory::get_author($term_id)) );
		}, array(
			'priority'		=> 100,
			'accepted_args'	=> 3,
		) );
	}

    /**
    *   Makes a cURL request based on the passed args
    *   @param mixed[] $args                                                    curl_setopt_array arguments
    *   @return mixed                                                           curl_exec result
    */
    static public function make_curl_req($args){
        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, $args);
        // execute
        $output = curl_exec($ch);
		// errors
		if (curl_errno($ch))
			error_log(curl_error($ch));
        // free
        curl_close($ch);
        return $output;
    }


    /**
    *   Inserts into the DB the latest articles
    *   @param int $days														Articles from $days ago
    */
    static public function insert_latest_articles($days = null){
		$days = $days ? $days : get_option('balancer_editorial_days', 20);
        $query = new WP_Query(array(
            'post_type' 		=> 'ta_article',
        	'orderby' 			=> 'date',
        	'order' 			=> 'DESC',
        	'posts_per_page'	=> -1,
        	'date_query' 		=> [
        		[
        			'column' => 'post_date_gmt',
        			'after'  => $days . ' days ago',
        		]
        	]
        ));
        $articles = $query && !is_wp_error($query) ? array_map( fn($post) => self::get_article_data(TA_Article_Factory::get_article($post)), $query->posts ) : null;
        // var_dump(wp_list_pluck($query->posts, 'ID'));
        if($articles){
            self::delete_all_articles();
            self::make_curl_req(array(
                CURLOPT_URL               	=> self::get_api_endpoint("/api/posts/allposts"),
                CURLOPT_RETURNTRANSFER    	=> true,
                CURLOPT_CUSTOMREQUEST 		=> 'POST',
                CURLOPT_HTTPHEADER			=> array('Content-Type: application/json', self::get_api_key_header()),
                CURLOPT_POSTFIELDS			=> json_encode($articles),
                CURLOPT_SSL_VERIFYHOST      => 0
            ));
        }
    }

    /**
    *   Creates or updates an article data
    *   @param mixed[] $article_data
    */
    static public function create_or_update_article($article_data){
        return self::make_curl_req(array(
            CURLOPT_URL               	=> self::get_api_endpoint("/api/posts/649846"),
            CURLOPT_RETURNTRANSFER    	=> true,
            CURLOPT_CUSTOMREQUEST 		=> 'PUT',
            CURLOPT_HTTPHEADER			=> array('Content-Type: application/json', self::get_api_key_header()),
            CURLOPT_POSTFIELDS			=> json_encode($article_data),
            CURLOPT_SSL_VERIFYHOST      => 0
        ));
    }

    /**
    *   Deletes an article from the db
    *   @param int $article_id
    */
    static public function delete_article($article_id){
        return self::make_curl_req(array(
            CURLOPT_URL               	=> self::get_api_endpoint("/api/posts/$article_id"),
            CURLOPT_RETURNTRANSFER    	=> true,
            CURLOPT_CUSTOMREQUEST 		=> 'DELETE',
            CURLOPT_HTTPHEADER			=> array('Content-Type: application/json', self::get_api_key_header()),
            CURLOPT_SSL_VERIFYHOST      => 0
        ));
    }

    /**
    *   Deletes every instance of a term from the balancer DB
    *   @param int $term_id
    *   @param string $taxonomy
    */
    static public function delete_term($term_id, $taxonomy){
        return self::make_curl_req(array(
            CURLOPT_URL               	=> self::get_api_endpoint("/api/posts/terms/324324234"),
            CURLOPT_RETURNTRANSFER    	=> true,
            CURLOPT_CUSTOMREQUEST 		=> 'PUT',
            CURLOPT_HTTPHEADER			=> array('Content-Type: application/json', self::get_api_key_header()),
            CURLOPT_POSTFIELDS			=> json_encode(array(
                'taxonomy'  => $taxonomy,
                'id'        => $term_id,
            )),
            CURLOPT_SSL_VERIFYHOST      => 0
        ));
    }

    /**
    *   Deletes all articles from the DB
    */
    static public function delete_all_articles(){
        return self::make_curl_req(array(
            CURLOPT_URL               	=> self::get_api_endpoint("/api/posts"),
            CURLOPT_RETURNTRANSFER    	=> true,
            CURLOPT_CUSTOMREQUEST 		=> 'DELETE',
            CURLOPT_HTTPHEADER			=> array('Content-Type: application/json', self::get_api_key_header()),
            CURLOPT_SSL_VERIFYHOST      => 0
        ));
    }

    /**
    *   Updates every instance of an author from the balancer DB
    *   @param mixed[] $author_data
    */
    static public function update_author($author_data){
        return self::make_curl_req(array(
            CURLOPT_URL               	=> self::get_api_endpoint("/api/posts/updateauthor/324324234"),
            CURLOPT_RETURNTRANSFER    	=> true,
            CURLOPT_CUSTOMREQUEST 		=> 'PUT',
            CURLOPT_HTTPHEADER			=> array('Content-Type: application/json', self::get_api_key_header()),
            CURLOPT_POSTFIELDS			=> json_encode($author_data),
            CURLOPT_SSL_VERIFYHOST      => 0
        ));
    }
}

TA_Balancer_DB::initialize();

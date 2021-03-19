<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

define('TA_ARTICLES_COMPATIBLE_POST_TYPES', ['ta_article', 'ta_audiovisual']);
define('TA_THEME_PATH', get_template_directory());
define('TA_THEME_URL', get_template_directory_uri());
define('TA_ASSETS_PATH', TA_THEME_PATH . "/assets");
define('TA_ASSETS_URL', TA_THEME_URL . "/assets");
define('TA_IMAGES_URL', TA_ASSETS_URL . "/img");
define('TA_ASSETS_CSS_URL', TA_THEME_URL . "/css");

require_once TA_THEME_PATH . '/inc/gen-base-theme/gen-base-theme.php';

class TA_Theme{
	static private $initialized = false;

	static public function initialize()
	{
		if (self::$initialized)
			return false;
		self::$initialized = true;

		self::add_themes_supports();
		self::register_menues();

		add_filter('generate_rewrite_rules', [self::class, 'sections_rules']);
		add_filter('post_type_link', [self::class, 'article_link'], 10, 2);


		if (is_admin()) {
			require_once TA_THEME_PATH . '/inc/attachments.php';
		}

		require_once TA_THEME_PATH . '/inc/functions.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Blocks_Container.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Blocks_Container_Manager.php';
		require_once TA_THEME_PATH . '/inc/classes/Data_Manager.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Article_Factory.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Article_Data.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Article.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Author_Factory.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Author_Data.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Author.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Tag_Factory.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Tag_Data.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Tag.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Section_Factory.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Section_Data.php';
		require_once TA_THEME_PATH . '/inc/classes/TA_Section.php';
		add_action('gen_modules_loaded', array(self::class, 'register_gutenberg_categories'));
		add_action('wp_enqueue_scripts', array(self::class, 'enqueue_scripts'));

		add_filter('gen_check_post_type_name_dash_error', function ($check, $post_type) {
			if ($post_type == 'tribe-ea-record')
				return false;
			return $check;
		}, 10, 2);

		self::get_plugins_assets();
	}

	static public function add_themes_supports()
	{
		add_theme_support('post-thumbnails');

		//svg support
		function cc_mime_types($mimes)
		{
			$mimes['svg'] = 'image/svg+xml';
			return $mimes;
		}
		add_filter('upload_mimes', 'cc_mime_types');
	}

	static private function register_menues()
	{
		RB_Wordpress_Framework::load_module('menu');
		register_nav_menus(
			array(
				'navbar-menu' => __('Navbar menú'),
				'dropwdown-header-menu' => __('Menú desplegable'),
				'footer-menu' => __('Footer menú'),
			)
		);
	}

	static public function enqueue_scripts(){
		wp_enqueue_style( 'bootstrap', TA_ASSETS_CSS_URL . '/libs/bootstrap/bootstrap.css' );
		wp_enqueue_style( 'ta_style', TA_ASSETS_CSS_URL . '/src/style.css' );
	}

	static public function register_gutenberg_categories()
	{
		rb_add_gutenberg_category('ta-blocks', 'Tiempo Argentino', null);
	}

	static public function sections_rules($wp_rewrite)
	{
		$rules = array();
		$post_type = 'ta_article';
		$terms = get_terms(array(
			'taxonomy' => 'ta_article_section',
			'hide_empty' => false,
		));
		foreach ($terms as $term) {
			$rules[$term->slug . '/([^/]*)$'] = 'index.php?post_type=' . $post_type . '&ta_article=$matches[1]&name=$matches[2]';
		}
		$wp_rewrite->rules = $rules + $wp_rewrite->rules;
	}


	static public function article_link($permalink, $post)
	{

		$get_terms = wp_get_post_terms($post->ID, array('ta_article_section'));
		$taxonomy = isset($get_terms[0]) && $get_terms[0] ? $get_terms[0]->taxonomy : null;

		if ($post->post_type == 'ta_article') {
			if ($taxonomy == 'ta_article_section') {
				$section_terms = get_the_terms($post, 'ta_article_section');
				$term_slug = '';
				if (!empty($section_terms)) {
					foreach ($section_terms as $term) {
						$term_slug = $term->slug;
						$unixtime = strtotime($post->post_date);
						$date = explode(" ", date('Y m d H i s', $unixtime));
						break;
					}
				}
				if ($post->post_status == 'publish') {
					$permalink = get_home_url() . '/' . $term_slug . '/' . $post->post_name . '/';
				}
			}
		}
		return $permalink;
	}
	/**
	 * Plugins
	 */
	static public function get_plugins_assets()
	{
		require_once TA_THEME_PATH . '/subscriptions-theme/functions.php';
		require_once TA_THEME_PATH . '/mailtrain/functions.php';
		
	}
}

TA_Theme::initialize();


function get_etiquetas($request)
{
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

add_action('rest_api_init', function () {
	register_rest_route('ta/v1', '/etiquetador', array(
		'methods' 				=> 'POST',
		'callback' 				=> 'get_etiquetas',
		'permission_callback'	=> '__return_true',
	) );
} );

add_action( 'rest_api_init', function () {
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

<?php

function show_interest_front($query)
{
    if (null !== $query && $query !== '') :
        foreach ($query as $art) :
?>
            <div class="article-preview vertical-article d-flex flex-column mb-3 col-12 col-md-3">
                <div>
                    <a href="">
                        <div class="img-container position-relative">
                            <div class="img-wrapper" style="background:url('<?php echo get_the_post_thumbnail_url($art->{'ID'}) ?>') center no-repeat !important;background-size: cover;">
                            </div>
                            <!-- iconos -->
                            <?php if (function_exists('balancer_front')) : ?>
                                <div class="iconos-container">
                                    <div class="article-icons d-flex flex-column position-absolute">
                                        <?php balancer_front()->show_interest_post(
                                            wp_get_current_user()->ID,
                                            $art->{'ID'},
                                            get_stylesheet_directory_uri() . '/assets/img/icon-img-1.svg',
                                            get_stylesheet_directory_uri() . '/assets/img/icon-img-2.svg',
                                            get_stylesheet_directory_uri() . '/assets/img/icon-img-3.svg'
                                        ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- iconos -->
                        </div>
                    </a>
                </div>
                <div class="content">
                    <div class="description">
                        <a href="<?php echo get_permalink($art->{'ID'}) ?>">
                            <p><?php echo get_the_title($art->{'ID'}) ?></p>
                        </a>
                    </div>
                    <div class="article-info-container">
                        <div>
                            <div class="author">
                                <?php $terms = get_the_terms($art->{'ID'}, get_option('balancer_editorial_autor')) ?>
                                <p>Por: <?php echo join(' y ', wp_list_pluck($terms, 'name')) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
        endforeach;
    endif;
}

add_action('wp_enqueue_scripts', 'place_ajax_vars');

add_action('wp_ajax_nopriv__balancer_action_theme', 'place_ajax_response');

add_action('wp_ajax__balancer_action_theme', 'place_ajax_response');

function place_ajax_vars()
{
    wp_enqueue_script('tar_balancer_ajax_script', get_template_directory_uri()  . '/balancer/js/tar-balancer-ajax.js', array('jquery'), '1.0', true);
    wp_localize_script('tar_balancer_ajax_script', 'balancer_place_ajax', [
        'url'    => admin_url('admin-ajax.php'),
        'action' => '_balancer_action_theme',
        'b_search' => isset($_POST['b_search']) ? $_POST['b_search'] : ''
    ]);
}

function place_ajax_response()
{
    if (isset($_POST['action'])) {

        if (isset($_POST['b_search'])) {
            global $wpdb;
            $results = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM wp_terms LEFT join wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id WHERE wp_term_taxonomy.taxonomy = %s AND wp_terms.slug LIKE %s", [get_option('balancer_editorial_place'), '%' . sanitize_title($_POST['b_search']) . '%'])
            );
            $form = '<ul id="suggest-ul">';
            foreach ($results as $r) {
                $form .= '<li class="suggest" data-id="' . $r->{'term_id'} . '">' . $r->{'name'} . '</li>';
            }
            $form .= '</ul>';
            echo $form;
            wp_die();
        } else {
            wp_send_json_error();
            wp_die();
        }
    }
}
/** tag cloud */

function tag_cloud_template()
{
    if (function_exists('balancer_personalize')) {

        if (is_user_logged_in()) {
            $topics = get_user_meta(wp_get_current_user()->ID, '_personalizer_topics', true);
            // echo sizeof($topics);
        }
        if ($topics === null) {
            require_once TA_THEME_PATH . '/balancer/tags/topics-cloud.php';
        }
    }
}

add_action('cloud_tag', 'tag_cloud_template');

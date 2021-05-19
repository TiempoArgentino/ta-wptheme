<?php
if(!function_exists('balancer_front'))
    return;

$posts = balancer_front()->interesting(4);
if(!$posts || !is_array($posts) || is_wp_error($posts))
    return;

$articles_block = RB_Gutenberg_Block::get_block('ta/articles');

if(!$articles_block)
    return;
    
$articles = array_map(function($post){ return TA_Article_Factory::get_article($post); }, $posts);
$articles_block->render(array(
    'articles'          => $articles,
    'rows'              => array(
        array(
            'format'            => 'common',
            'cells_amount'      => 4,
            'cells_per_row'     => 4,
            'fill'              => true,
        ),
    ),
    'use_container'     => true,
    'container'         => array(
        'header_type'			=> 'common',
        'color_context'			=> 'light-blue-bg',
        'title'					=> __('SEGÚN TUS INTERESES','gen-theme-base'),
        'header_right'          => function(){
            if(is_user_logged_in()): ?>
            <div class="btns-container d-none d-lg-block">
                <div class="personalizar">
                    <button><a href="<?php echo get_permalink(get_option('personalize'))?>"><?php echo __('PERSONALIZAR','gen-theme-base')?></a></button>
                </div>
            </div>
            <?php endif;
        },
        'footer'                => function(){
            if(is_user_logged_in()): ?>
                <div class="btns-container d-flex justify-content-between justify-content-lg-end">
                    <div class="personalizar d-block d-lg-none">
                        <button><a href="<?php echo get_permalink(get_option('personalize'))?>"><?php echo __('PERSONALIZAR','gen-theme-base')?></a></button>
                    </div>
                </div>
            <?php endif;
        },
        // 'header_link'			=> '',
        // 'use_term_format'		=> false,
    ),
));
?>

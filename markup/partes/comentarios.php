<?php
if(!comments_open($post))
    return;
$article = TA_Article_Factory::get_article($post);
$comments_amount = get_comments_number($post->ID);
$header_title = $article->participation['use'] ? 'PREGUNTÁ Y PARTICIPÁ' : 'COMENTARIOS';
?>
<div class="container-with-header" id="comments-container">
    <div>
        <div class="section-title">
            <h4><?php echo $header_title; ?></h4>
        </div>
    </div>
    <div class="mt-3">
        <div class="ta-comentarios-block">
            <div class="px-md-5">
                <?php if($article->participation['use']): ?>
                <div class="header-container">
                    <div class="d-flex align-items-end">
                        <?php if($article->participation['use_live_date'] && $article->participation['live_date']): ?>
                        <div class="date">
                            <p><?php echo date('d F G:i\h\s', $article->participation['live_date'] / 1000); ?> - </p>
                        </div>
                        <?php endif; ?>
                        <?php
                        if($article->participation['live_title']):
                            $anchor_href = $article->participation['live_link'] ? "href='".esc_attr($article->participation['live_link'])."'" : '';
                        ?>
                        <div class="title">
                            <a <?php echo $anchor_href; ?>><p><?php echo $article->participation['live_title']; ?></p></a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="author-name">
                        <p><?php get_template_part('parts/article','authors_links', array( 'authors' => $article->authors )); ?></p>
                    </div>
                    <div class="description mt-3">
                        <p>El autor responderá preguntas de esta noticia. <span>¡Es tu momento de participar!</span></p>
                    </div>
                </div>
                <?php endif; ?>

                <div class="input-quantity">
                    <p><span class="comments-amount"><?php echo esc_html($comments_amount); ?></span> <?php echo $comments_amount == 1 ? "Comentario" : "Comentarios"; ?></p>
                </div>
                <?php
                comment_form(array(
                    'fields'                => [ 'cookies'  => '' ],
                    'comment_field'         => ta_get_comment_form_fields_as_string(),
                    'comment_notes_before'  => '',
                    'comment_notes_after'   => '',
                    'logged_in_as'          => '',
                    'title_reply'           => '',
                    'submit_button'         => '',
                ));
                ?>
                <div class="input-container" id="ta-comentarios">
                    <?php
                    $current_user_id = get_current_user_id();
                    if($current_user_id){
            			get_template_part('parts/article', 'comments', array(
                            'post_id'           => $post->ID,
                            'paged'			  => 1,
                            'number'            => null,
                            'author__in'        => $current_user_id ? [$current_user_id] : null,
                        ));
                    }
                    ?>
                    <div class="separator-grey"></div>
                    <?php
        			get_template_part('parts/article', 'comments', array(
                        'post_id'               => $post->ID,
                        'paged'                 => 1,
                        'author__not_in'        => $current_user_id ? [$current_user_id] : null,
                    ));
                    ?>
                </div>
                <?php if($comments_amount >= 10): ?>
                <div class="btns-container">
                    <div class="ver-mas text-right">
                        <button id="load-comments-btn">ver más<span class="ml-3 "><img src="<?php echo TA_THEME_URL; ?>/assets/img/right-arrow.png" alt="" /></span></button>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
            if(function_exists('tweets_search_front')){
                echo tweets_search_front()->get_tweets(get_queried_object_id());
            }
        ?>
</div>

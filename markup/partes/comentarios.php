<?php
$comments_amount = get_comments_number($post->ID);
?>
<div class="container-with-header">
    <div>
        <div class="section-title">
            <h4>COMENTARIOS</h4>
        </div>
    </div>
    <div class="mt-3">
        <div class="ta-comentarios-block">
            <div class="px-md-5">
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
</div>

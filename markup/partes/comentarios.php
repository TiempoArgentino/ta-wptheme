<?php
function get_article_comments($args = array()){
    global $post;
    $default_args = array(
        'status'            => 'approve',
        'post_id'           => $post->ID,
        'orderby'           => ['meta_value' => 'ASC', 'comment_date' => 'DESC'],
        'meta_key'          => 'is_visitor',
        'parent__in'        => [0],
        'comment__not_in'   => [],
        'paged'             => 1,
        'number'            => 10,
    );
    $args = array_merge($default_args, $args);

    $comments = get_comments($args);

    if(is_wp_error($comments))
        return [];

    foreach ($comments as $comment) {
        $child_comments = get_comments(array(
            'status'            => 'approve',
            'meta_key'          => 'is_visitor',
            'meta_value'        => false,
            'parent__in'        => [$comment->comment_ID],
            'number'            => 1,
        ));
        $comment->replies = $child_comments;
    }

    return $comments;
}

$comments = get_article_comments(array(
    'post_id'   => $post->ID,
    'page'      => 1,
    'per_page'  => 10,
));
$comments_amount = count($comments);
// var_dump($comments);
// get_article_comments();
function input_field_string(){
    $user = wp_get_current_user();
    $is_logged = $user->ID != 0;
    // var_dump($user);
    ob_start();
    ?>
    <div class="fields">

        <?php if(!$is_logged): ?>
        <div class="input-box d-flex justify-content-center mb-2">
            <div class="input-container position-relative w-100">
                <div class="input-wrapper">
                    <span><input placeholder="Nombre" name="author" required="required" class></span>
                </div>
            </div>
        </div>
        <div class="input-box d-flex justify-content-center mb-2">
            <div class="input-container position-relative w-100">
                <div class="input-wrapper">
                    <span><input placeholder="Email" type="email" name="email" required="required" class></span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="input-box d-flex justify-content-center mb-2">
            <div class="input-container position-relative w-100">
                <div class="input-wrapper">
                    <span><input placeholder="Dejá tu comentario"  name="comment" maxlength="65525" required="required" class></span>
                </div>
                <div class="input-icon">
                    <button class="position-absolute">
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/emoji.svg" alt="" class="w-100" />
                    </button>
                </div>
            </div>
            <div class="send-btn d-flex align-items-center">
                <button><img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/send.svg" alt="" /></button>
            </div>
        </div>

        <div class="general-error">
            <p class="error-message"></p>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
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
                    <p><?php echo esc_html($comments_amount); ?> <?php echo $comments_amount == 1 ? "Comentario" : "Comentarios"; ?></p>
                </div>
                <?php
                comment_form(array(
                    'fields'                => [ 'cookies'  => '' ],
                    'comment_field'         => input_field_string(),
                    'comment_notes_before'  => '',
                    'comment_notes_after'   => '',
                    'logged_in_as'          => '',
                    'title_reply'           => '',
                    'submit_button'         => '',
                ));
                ?>
                <div class="input-container" id="ta-comentarios">
                    <?php
                    foreach($comments as $comment){
                        get_template_part('parts/participation', 'comment', array( 'comment' => $comment ));
                    }
                    ?>
                </div>
                <div class="btns-container">
                    <div class="ver-mas text-right">
                        <button>ver más<span class="ml-3 "><img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/right-arrow.png"
                                    alt="" /></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

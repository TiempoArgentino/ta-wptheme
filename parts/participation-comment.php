<?php
$defaults = array(
    'comment'   => null,
    'author'    => null,
);
extract( array_merge( $defaults, $args ) );
if(!$comment || empty($comment) )
    return;

$avatar_url = get_avatar_url($comment->user_id);
$name = $comment->comment_author;
$date = date("j F o - H:i", strtotime($comment->comment_date));
$content = $comment->comment_content;
$is_partner = true;
$has_reply = true;
$user_data = get_userdata($comment->user_id);
$container_class = "";
if($user_data){
    if(in_array('subscriber', $user_data->roles)){
        $container_class .= " partner";
        $is_partner = true;
    }
}
if( $author ){
    $avatar_url = $author->photo;
    $name = $author->name;
}
?>

<?php if($has_reply): ?>
<div class="with-reply">
    <div class="single-comment position-relative input d-flex justify-content-between my-3 my-md-4 <?php echo esc_attr($container_class); ?>">
        <div class="profile position-absolute h-100">
            <div class="picture position-relative mb-3 mb-md-4">
                <img src="<?php echo esc_attr($avatar_url); ?>" alt="" class="img-fluid" />
                <?php if($is_partner): ?>
                    <div class="icon position-absolute">
                        <img src="<?php echo TA_THEME_URL; ?>/assets/img/partner-yellow.svg" alt="" />
                    </div>
                <?php endif; ?>
            </div>
            <div class="line-container">
                <div class="line"></div>
            </div>
        </div>
        <div class="content w-100">
            <div class="user-info">
                <p><?php echo esc_html($name); ?><?php if($is_partner): ?> <span class="yellow-tag">|
                        Socio</span><?php endif; ?></p>
            </div>
            <div class="date">
                <p><?php echo esc_html($date); ?></p>
            </div>
            <div class="input-body">
                <p><?php echo esc_html($content); ?></p>
            </div>
        </div>
    </div>
    <div
        class="single-comment position-relative response input d-flex justify-content-between my-3 my-md-4 <?php echo esc_attr($container_class); ?>">
        <div class="profile position-absolute h-100">
            <div class="picture  position-relative">
                <img src="<?php echo esc_attr($avatar_url); ?>" alt=""  class="img-fluid" />
                <?php if($is_partner): ?>
                    <div class="icon position-absolute">
                        <img src="<?php echo TA_THEME_URL; ?>/assets/img/partner-yellow.svg" alt="" />
                    </div>
                <?php endif; ?>
            </div>
            
        </div>
        <div class="content w-100">
            <div class="user-info">
                <p><?php echo esc_html($name); ?><?php if($is_partner): ?> <span class="yellow-tag">|
                        Socio</span><?php endif; ?></p>
            </div>
            <div class="date">
                <p><?php echo esc_html($date); ?></p>
            </div>
            <div class="input-body">
                <p><?php echo esc_html($content); ?></p>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="single-comment position-relative input d-flex justify-content-between my-md-4 <?php echo esc_attr($container_class); ?>">
    <div class="profile  position-absolute h-100">
        <div class="picture  position-relative">
            <img src="<?php echo esc_attr($avatar_url); ?>" alt=""  class="img-fluid" />
            <?php if($is_partner): ?>
                <div class="icon position-absolute">
                    <img src="<?php echo TA_THEME_URL; ?>/assets/img/partner-yellow.svg" alt="" />
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="content w-100">
        <div class="user-info">
            <p><?php echo esc_html($name); ?><?php if($is_partner): ?> <span class="yellow-tag">|
                    Socio</span><?php endif; ?></p>
        </div>
        <div class="date">
            <p><?php echo esc_html($date); ?></p>
        </div>
        <div class="input-body">
            <p><?php echo esc_html($content); ?></p>
        </div>
    </div>
</div>
<?php endif; ?>
<?php

if($comment->replies && !empty($comment->replies)){
    global $post;
    $article = TA_Article_Factory::get_article($post);

    if($article && $article->first_author){
        $reply = $comment->replies[0];
        $reply_author = $article->first_author; // fallback to article first author
        $reply_author_id = get_comment_meta($reply->comment_ID, 'ta_comment_author', true);

        if($reply_author_id){
            $author_term = get_term_by('term_id', $reply_author_id, 'ta_article_author');
            $comment_meta_author = TA_Author_Factory::get_author($author_term);
            $matching_article_authors = array_filter($article->authors, function($article_author) use ($comment_meta_author){ return $article_author->ID == $comment_meta_author->ID; });
            if( !empty( $matching_article_authors ) )
                $reply_author = $comment_meta_author;
        }

        get_template_part('parts/participation', 'comment', array(
            'comment'   => $reply,
            'author'    => $reply_author,
        ));
    }

}

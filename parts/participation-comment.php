<?php
$defaults = array(
    'comment'   => null,
);
extract( array_merge( $defaults, $args ) );
if(!$comment || empty($comment) )
    return;

$avatar_url = get_avatar_url($comment->user_id);
$name = $comment->comment_author;
$date = date("j F o - H:i", strtotime($comment->comment_date));
$content = $comment->comment_content;
$is_partner = false;
$user_data = get_userdata($comment->user_id);
$container_class = "";
if($user_data){
    if(in_array('subscriber', $user_data->roles)){
        $container_class .= " partner";
        $is_partner = true;
    }
}
?>
<div class="single-comment input d-flex justify-content-between my-md-4 <?php echo esc_attr($container_class); ?>">
    <div class="profile  position-relative">
        <div class="picture">
            <img src="<?php echo esc_attr($avatar_url); ?>" alt="" />
        </div>
        <?php if($is_partner): ?>
        <div class="partner-icon">
            <div class="icon position-absolute">
                <img src="<?php echo TA_THEME_URL; ?>/assets/img/partner-yellow.svg" alt="" />
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="content ml-2 w-100">
        <div class="user-info">
            <p><?php echo esc_html($name); ?><?php if($is_partner): ?> <span class="yellow-tag">| Socio</span><?php endif; ?></p>
        </div>
        <div class="date">
            <p><?php echo esc_html($date); ?></p>
        </div>
        <div class="input-body">
            <p><?php echo esc_html($content); ?></p>
        </div>
    </div>
</div>

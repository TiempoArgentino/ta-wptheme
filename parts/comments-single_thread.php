<?php
$template_args = ta_get_commment_display_data($args);
if(!$template_args)
    return;
extract($template_args);

?>
<div class="comment-thread my-3 my-md-1">
    <div id="comment-<?php echo esc_attr($comment->comment_ID); ?>" class="single-comment position-relative input d-flex justify-content-between <?php echo esc_attr($container_class); ?>" data-id="<?php echo esc_attr($comment->comment_ID); ?>">
        <div class="profile position-absolute h-100">
            <div class="picture position-relative mb-3 mb-md-2">
                <img src="<?php echo esc_attr($avatar_url); ?>" alt="" class="img-fluid" />
                <?php if($author || $user_manages_comments): ?>
                    <div class="icon position-absolute">
                        <img src="<?php echo TA_THEME_URL; ?>/assets/img/partner-blue.png" alt="" />
                    </div>
                <?php elseif($is_partner): ?>
                    <div class="icon position-absolute">
                        <img src="<?php echo TA_THEME_URL; ?>/assets/img/partner-yellow.svg" alt="" />
                    </div>
                <?php endif; ?>
            </div>
            <?php if($reply_data): ?>
            <div class="line-container">
                <div class="line"></div>
            </div>
            <?php endif; ?>
        </div>
        <div class="content w-100">
            <div class="user-info">
                    <p><?php echo esc_html($name); ?>
                        <?php if($author): ?>
                        <span class="blue-tag">| Autor</span>
                        <?php elseif($user_manages_comments): ?>
                        <span class="blue-tag">| Editor</span>
                        <?php elseif($is_partner): ?>
                        <span class="yellow-tag">| Socio</span>
                        <?php endif; ?>
                    </p>
            </div>
            <div class="date">
                <p><?php echo esc_html($date); ?></p>
            </div>
            <div class="input-body">
                <p><?php echo esc_html($content); ?></p>
            </div>
        </div>
    </div>
    <?php
    if($reply_data){
        get_template_part('parts/comments', 'single_thread', array_merge($reply_data, array(
            'show_reply'    => false,
        )));
    }
    ?>
</div>

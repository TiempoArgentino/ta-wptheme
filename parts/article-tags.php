<?php
$defaults = array(
    'tags'      => null,
    'class'     => '',
);
extract(array_merge($defaults, $args));

if(!is_array($tags) || empty($tags))
    return;
?>

<div class="article-tags d-flex flex-wrap <?php echo esc_attr($class); ?>">
    <?php foreach( $tags as $tag ): ?>
    <div class="tag d-flex justify-content-center my-2">
        <div class="content p-1">
            <a href="<?php echo esc_attr($tag->archive_url); ?>">
                <p class="m-0"><?php echo esc_html($tag->name); ?></p>
            </a>
        </div>
        <div class="triangle"></div>
    </div>
    <?php endforeach; ?>
</div>

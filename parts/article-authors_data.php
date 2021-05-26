<?php
$defaults = array(
    'article'   => null,
);
extract(array_merge($defaults, $args));
if(!$article)
    return;

if(!$article->authors || empty($article->authors))
    return;
?>
<div class="d-flex flex-column flex-md-row mt-2 mt-md-3">
    <?php foreach($article->authors as $author): ?>
        <div class="author d-flex mx-2">
            <?php if(!$author->has_photo): ?>
            <div class="author-icon mr-2">
                <img src="<?php echo TA_THEME_URL; ?>/assets/img/author-pen.svg" alt="" />
            </div>
            <?php else: ?>
            <div class="author-img" style="background-image: url('<?php echo esc_attr($author->photo); ?>');">
                <div class="author-icon mr-2">
                    <img src="<?php echo TA_THEME_URL; ?>/assets/img/author-pen.svg" alt="" />
                </div>
            </div>
            <?php endif; ?>
            <div class="author-info">
                <p>Por: <a href="<?php echo esc_attr($author->archive_url); ?>"><?php echo esc_html($author->name); ?></a></p>
                <?php if(isset($article->authors_roles[$author->ID]) && $article->authors_roles[$author->ID]): ?>
                <p><?php echo esc_html($article->authors_roles[$author->ID]); ?></p>
                <?php endif; ?>
                <?php if($author->social): ?>
                <a href="<?php echo esc_attr($author->social['url']); ?>">@<?php echo esc_html($author->social['user']); ?></a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

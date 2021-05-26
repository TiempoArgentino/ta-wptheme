<?php
$article = TA_Article_Factory::get_article($post);
$tags = $article->tags;

if(!is_array($tags) || empty($tags))
    return;
?>
<div class="container">
    <div class="article-tags d-flex flex-wrap mt-4">
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
</div>
<div class="container-md mb-2 p-0 d-none">
    <div class="separator"></div>
</div>

<?php
$block = RB_Gutenberg_Block::get_block('ta/article-preview');

if(!$block) return '';
extract($block->get_render_attributes());

if( !$article ){
    if( $article_data && $article_type ){
        $article = TA_Article_Factory::get_article($article_data, $article_type);
        if( !$article )
            return '';
    }
    else
        return '';
}

$thumbnail = $article->get_thumbnail();
$thumbnail_url = $thumbnail ? $thumbnail['url'] : '';
$thumb_cont_class = $desktop_horizontal ? 'col-3 p-0' : '' ;
$info_class = $desktop_horizontal ? 'mt-0 col-9' : '';
?>

<div class="article-preview horizontal d-flex flex-row flex-lg-column mt-3 <?php echo esc_attr($class); ?>">
    <?php if( $thumbnail_url ): ?>
    <div class="<?php echo esc_attr($thumb_cont_class); ?>">
        <a href="<?php echo esc_attr($article->url); ?>">
            <div class="img-container position-relative">
                <div class="img-wrapper">
                    <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo esc_attr($thumbnail['alt']); ?>" />
                </div>
                <div class="icons-container">
                    <div class="article-icons d-flex flex-column position-absolute">
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-1.svg" alt="" />
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-2.svg" alt="" />
                        <img src="<?php echo TA_THEME_URL; ?>/markup/assets/images/icon-img-3.svg" alt="" />
                    </div>
                </div>
            </div>
        </a>
        <div class="date text-right">
            <p class="mb-1"><?php echo esc_html($article->get_date_day('d/m/Y')); ?></p>
        </div>
    </div>
    <?php endif; ?>
    <div class="content <?php echo esc_attr($info_class); ?>">
        <?php if($article->cintillo): ?>
        <div class="article-border"></div>
        <div class="category-title">
            <h4><?php echo $article->cintillo; ?></h4>
        </div>
        <?php endif; ?>
        <div class="description">
            <a href="<?php echo esc_attr($article->url); ?>">
                <p><?php echo $article->title; ?></p>
            </a>
        </div>
        <?php
        if($show_authors && $article->authors):
            $authors_text = "";

        ?>
        <div class="article-info-container">
            <div class="author">
                <p>Por:
                <?php for ($i=0; $i < count($article->authors); $i++): ?>
                    <a href="<?php echo esc_attr($article->authors[$i]->archive_url); ?>"><?php echo esc_html($article->authors[$i]->name); ?></a>
                    <?php if( isset($article->authors[$i + 1]) ): ?> y<?php endif; ?>
                <?php endfor; ?>
                </p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

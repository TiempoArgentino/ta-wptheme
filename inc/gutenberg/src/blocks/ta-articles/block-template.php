<?php
$block = RB_Gutenberg_Block::get_block('ta/articles');
$article_preview_block = RB_Gutenberg_Block::get_block('ta/article-preview');
$container_header_block = RB_Gutenberg_Block::get_block('ta/container-with-header');
register_articles_block_cells_count(0);

if(!$block) return '';
$block_attributes = $block->get_render_attributes();
extract($block_attributes);

$articles = get_ta_articles_block_articles($block_attributes);
if( (!$articles || empty($articles)) || !$rows )
    return '';

$all_articles = $articles;
$block_path = plugin_dir_path( __FILE__ );
$use_container = true;
ob_start();
?>

<?php
foreach ($rows as $row) {
    $offset = get_articles_block_cells_count();
    $articles = array_slice($articles, $offset);
    $format = isset($row['format']) ? $row['format'] : null;
    switch($format){
        case 'slider':
            include "$block_path/templates/slider.php";
        break;
        case 'miscelanea':
            include "$block_path/templates/miscelanea.php";
        break;
        default:
            include "$block_path/templates/common-infinite.php";
        break;
    }
}
register_articles_block_cells_count(0);
?>

<?php if( $footer ): ?>
<div class="footer">
    <?php echo $footer; ?>
</div>
<?php endif; ?>


<?php
$content = ob_get_clean();

if( $use_container && $container ){
    if(isset($container['use_term_format']) && $container['use_term_format']){
        $term_data = ta_is_term_articles_block($block_attributes);
        if( $term_data ){
            $new_container_args = array();
            $term_taxonomy = $term_data->term->taxonomy;
            $term_slug = $term_data->term->slug;
            $new_container_args['title'] = $term_data->name;
            $new_container_args['header_link'] = $term_data->archive_url;

            if(($term_taxonomy == 'ta_article_section') && ($term_slug == 'cultura' || $term_slug == 'deportes' || $term_slug == 'espectaculos')){
                $new_container_args['color_context'] = $term_slug;
                $new_container_args['header_type']  = 'common';
            }

            $container = array_merge( $container, $new_container_args );
        }
    }
    $container_header_block->render($container, $content);
}
else
    echo $content;

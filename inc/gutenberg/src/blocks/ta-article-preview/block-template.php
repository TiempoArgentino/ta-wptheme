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

$block_path = plugin_dir_path( __FILE__ );
$thumbnail = $article->thumbnail_alt_common ? $article->thumbnail_alt_common : $article->thumbnail_common;
$thumbnail_url = $thumbnail ? $thumbnail['url'] : '';
$thumb_cont_class = $desktop_horizontal ? 'col-3 p-0' : '' ;
$info_class = $desktop_horizontal ? 'mt-0 col-9' : '';

$class = $class ? "$class" : "";
$title = $article->title;
$cintillo = $article->cintillo;
$url = $article->url;
$authors = $show_authors ? $article->authors : null;

if($size == 'large')
    $class .= ' destacado';
// if($desktop_horizontal == true)
//     $class .= ' horizontal';

if(!$deactivate_opinion_layout)
    $layout = $article->isopinion ? 'opinion' : $layout;

switch ($layout) {
    case 'opinion':
        include "$block_path/templates/opinion.php";
    break;
    case 'common-tiny':
        include "$block_path/templates/common-tiny.php";
    break;
    default:
        include "$block_path/templates/common.php";
    break;
}
?>

<?php
$block = RB_Gutenberg_Block::get_block('ta/articles');
$article_preview_block = RB_Gutenberg_Block::get_block('ta/article-preview');
$container_header_block = RB_Gutenberg_Block::get_block('ta/container-with-header');

if(!$block) return '';
extract($block->get_render_attributes());

if( !$articles && !$articles_data ) return '';

$block_path = plugin_dir_path( __FILE__ );
ob_start();
?>

<?php
switch($layout){
    case 'slider':
        include "$block_path/slider.php";
    break;
    default:
        include "$block_path/common-infinite.php";
    break;
}
?>

<?php if( $footer ): ?>
<div class="footer">
    <?php echo $footer; ?>
</div>
<?php endif; ?>


<?php
$content = ob_get_clean();

if( $use_container){
    $container_header_block->render(array(
        'title'             => $container_title,
        'header_right'      => $header_right,
        'color_context'     => $color_context,
    ), $content);
}
else
    echo $content;

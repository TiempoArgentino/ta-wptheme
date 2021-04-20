<?php
$block = RB_Gutenberg_Block::get_block('ta/container-with-header');

if(!$block) return '';
extract($block->get_render_attributes());

if( !$title && !$content ) return '';

$header_class = $header_right ? 'd-block d-lg-flex justify-content-between align-items-center' : '';
$container_closed = TA_Blocks_Container_Manager::close();
$header_link_tag = $header_link ? 'href="'. esc_attr($header_link) .'"' : '';
?>

<div class="container-with-header ta-context <?php echo esc_attr($color_context); ?> py-3">
    <div class="context-color">
        <div class="container line-height-0">
            <div class="separator m-0"></div>
        </div>
        <div class="context-bg  py-3">
            <div class="container <?php echo esc_attr($header_class); ?>">
                <a <?php echo $header_link_tag; ?> class="section-title">
                    <h4><?php echo $title; ?></h4>
                </a>
            </div>
            <div class="sub-blocks mt-3">
                <div class="container">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
</div>




<?php $container_closed ? TA_Blocks_Container_Manager::reopen() : false; ?>

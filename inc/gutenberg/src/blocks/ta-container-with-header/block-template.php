<?php
$block = RB_Gutenberg_Block::get_block('ta/container-with-header');

if(!$block) return '';
extract($block->get_render_attributes());

if( !$title && !$content ) return '';


$header_class = $header_right ? 'd-block d-lg-flex justify-content-between align-items-center' : '';

?>

<div>
    <div class="container-md p-0 line-height-0 mt-3">
            <div class="separator"></div>
    </div>
    <div class="container-with-header py-3 ta-context <?php echo esc_attr($color_context); ?>">
        <div class="container <?php echo esc_attr($header_class); ?>">
            <div class="section-title">
                <h4><?php echo $title; ?></h4>
            </div>
            <?php if($header_right): ?>
            <div class="content">
                <?php echo $header_right; ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="sub-blocks mt-3">
            <div class="container px-0 px-md-1">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>

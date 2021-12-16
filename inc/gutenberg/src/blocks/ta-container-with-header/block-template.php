<?php
$block = RB_Gutenberg_Block::get_block('ta/container-with-header');

if(!$block) return '';
extract($block->get_render_attributes());

if( !$title && !$content ) return '';

global $is_rendering_inner_blocks;
$has_header_right = $header_right && is_callable($header_right) ? true : false;
$has_footer = $footer && is_callable($footer) ? true : false;
$header_class = $has_header_right ? 'd-block d-lg-flex justify-content-between align-items-center' : '';
$container_closed = !$is_rendering_inner_blocks ? TA_Blocks_Container_Manager::close() : null;
$header_link_tag = $header_link ? 'href="'. esc_attr($header_link) .'"' : '';
?>

<div class="container-with-header ta-context <?php echo esc_attr($color_context); ?> py-3">
    <div class="context-color">
        <?php if($header_type == 'common'): ?>
        <div class="container line-height-0">
            <div class="separator m-0"></div>
        </div>
        <?php endif; ?>
        <div class="context-bg  py-3">
            <div class="container <?php echo esc_attr($header_class); ?>">
                <?php if($header_type == 'common'): ?>
                <a <?php echo $header_link_tag; ?> class="section-title">
                    <h4><?php echo $title; ?></h4>
                </a>
                <?php elseif($header_type == 'especial'): ?>
                <div class="article-tags ta-blue-bg m-0">
                    <div class="tag d-flex my-2">
                        <div class="content p-1">
                            <a <?php echo $header_link_tag; ?>>
                                <p class="m-0"><?php echo $title; ?></p>
                            </a>
                        </div>
                        <div class="triangle"></div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if($has_header_right){ call_user_func($header_right); }?>
            </div>
            <div class="sub-blocks mt-3">
                <div class="container">
                    <?php echo $content; ?>
                    <?php if($has_footer){ call_user_func($footer); }?>
                </div>
            </div>
        </div>
    </div>
</div>




<?php $container_closed ? TA_Blocks_Container_Manager::reopen() : false; ?>

<?php
$block = RB_Gutenberg_Block::get_block('ta/quote');

if(!$block) return '';
extract($block->get_render_attributes());

if( !$quote && !$author ) return '';
?>

<div class="featured-quote mt-4">
    <div class="quote-body">
        <p>
        “<?php echo esc_html($quote); ?>“
        </p>
    </div>
    <div class="author-quoted mt-2">
        <p><?php echo esc_html($author); ?></p>
    </div>
</div>

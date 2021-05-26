<?php

$block = RB_Gutenberg_Block::get_block('ta/mow');
$container_header_block = RB_Gutenberg_Block::get_block('ta/container-with-header');

if(!$block) return '';
$block_attributes = $block->get_render_attributes();
extract($block_attributes);

if(!$mow_code)
    return;

$xml = simplexml_load_string($mow_code);

if(!$xml)
    return;

$xml_attributes = $xml->attributes();
$src = (string) $xml_attributes->src;
if(!$src || strpos($src, "//mowplayer.com/watch/js") != 0)
    return;

if( $use_container && $container ){
    $container_header_block->render($container, $mow_code);
}
else
    echo $mow_code;

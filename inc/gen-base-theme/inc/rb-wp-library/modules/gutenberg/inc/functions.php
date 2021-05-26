<?php

function rb_add_gutenberg_category($slug, $title, $icon = null){
    RB_Gutenberg_Categories::add_blocks_category($slug, $title, $icon);
}

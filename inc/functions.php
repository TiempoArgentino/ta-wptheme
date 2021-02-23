<?php

/**
*   Focus position for the attachment image.
*   @param int $attachment_id
*   @return string[]
*/
function ta_get_attachment_positions($attachment_id){
    if(!is_int($attachment_id))
        return null;
    return array(
        'x'     => get_post_meta( $attachment_id, 'ta_attachment_position_x', true ),
        'y'     => get_post_meta( $attachment_id, 'ta_attachment_position_y', true ),
    );
}

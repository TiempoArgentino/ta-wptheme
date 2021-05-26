<?php

class RB_Images_Gallery_Control extends RB_Field_Control{

    public function __construct($value, $settings) {
         parent::__construct($value, $settings);
         $this->settings['repeatable']  = true;
         $this->settings = wp_parse_args( $settings, $this->settings);
    }

    public function wp_get_attachment($attachment_id){
        $attachment = get_post( $attachment_id );
		return array(
			'id'	=> $attachment_id,
			'thumbnail' => wp_get_attachment_thumb_url( $attachment_id ),
			'title' => $attachment->post_title,
			'caption' => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'link' => get_permalink( $attachment->ID ),
			'url' => $attachment->guid,
			'type' => get_post_mime_type( $attachment_id ),
			'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'video_url'	=> get_post_meta( $attachment->ID, 'rb_media_video_url', true ),
		);
    }

    public function render_content(){
        $attachments_ids_csv = $this->value;
        $attachments_ids = array();
        //Se parsean csv para mantener compatibilidad con versiones anteriores
        if($attachments_ids_csv){
            $first_char = substr($attachments_ids_csv, 0, 1);
            $isjson = $first_char == '{' || $first_char == '[';

            if($isjson)
                $attachments_ids = json_decode($attachments_ids_csv, true);
            else
                $attachments_ids = array_map(function( $att_id ){
                    return array(
                        'id'    => $att_id,
                    );
                }, str_getcsv($attachments_ids_csv));
        }

        extract($this->settings);
        ?>
        <?php $this->print_control_header(); ?>
        <div class="rb-images-gallery-control rb-tax-images rb-tax-images-control" <?php $this->repeatable_attr(); ?>>
            <input <?php $this->print_input_link(); ?> class="rb-tax-value <?php $this->print_input_classes(); ?>"  name="<?php echo $id; ?>" type="hidden" value="<?php echo esc_attr($attachments_ids_csv); ?>"></input>
            <div class="rb-tax-images-boxes">
                <?php
                if ($attachments_ids):
                    foreach($attachments_ids as $attachment_data ):
                        $attachment_id = $attachment_data['id'];
                        $attachment = $this->wp_get_attachment( $attachment_id );
                ?>
                <div class="rb-tax-image rb-gallery-box" rel="<?php echo $attachment_id; ?>" style="background-image: url(<?php echo $attachment['thumbnail']; ?>);">
                    <i class="fas fa-times rb-remove"></i>
                </div>
                <?php
                    endforeach;
                endif;
                ?>
                <div class="rb-tax-add rb-gallery-box">
                    <i class="fas fa-plus rb-add"></i>
                </div>
            </div>
        </div>
        <?php
    }

    public function repeatable_attr(){
        if( !$this->settings['repeatable'] )
            print_r("data-unique=''");
    }
}

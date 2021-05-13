<?php
$defaults = array(
    'authors'   => null,
);
extract( array_merge( $defaults, $args ) );
if(!$authors || empty($authors) )
    return;

$amount = count($authors);
?>
<?php for ($i=0; $i < $amount; $i++): ?>
    <a href="<?php echo esc_attr($authors[$i]->archive_url); ?>"><?php echo esc_html($authors[$i]->name); ?></a><?php
        if( isset($authors[$i + 1]) ){
            if( $i + 2 == $amount )
                echo " y";
            else
                echo ",";
        }
    ?>
<?php endfor; ?>

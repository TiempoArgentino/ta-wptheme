<?php
extract($args);
$class = $open ? 'active' : '';
$id_attr = $id ? `id="$id"` : '';
?>
<div <?php echo $id_attr; ?> class="rb-field rb-collapsible <?php echo $class; ?>">
    <div class="control-header rb-collapsible-header">
        <h1 class="title"><?php echo $title; ?></h1>
    </div>
    <div class="control-body rb-collapsible-body">
        <?php
        if(is_callable($content))
            call_user_func($content);
        else if( is_string($content) )
            echo $content;
        ?>
    </div>
</div>

<?php include( TA_THEME_PATH . "/markup/partes/articulo-especial.php" ); ?>
<div class="container">
    <?php
    get_template_part('parts/article', 'tags', array(
        'tags'      => $article->tags,
        'class'    => 'mt-4',
    ));
    ?>
    <?php include_once(TA_THEME_PATH . "/markup/partes/sponsor.php");  ?>
    <?php include_once(TA_THEME_PATH . "/markup/partes/newsletter-especial.php");  ?>
    <?php include(TA_THEME_PATH . "/markup/partes/segun-tus-intereses.php");  ?>
    <?php include_once(TA_THEME_PATH . "/markup/partes/comentarios.php");  ?>
    <?php include_once(TA_THEME_PATH . "/markup/partes/pregunta-y-participa.php");  ?>
    <?php include_once(TA_THEME_PATH . "/markup/partes/conversemos.php");  ?>
</div>
<?php include_once(TA_THEME_PATH . "/markup/partes/relacionados-tema.php");  ?>
<div class="container">
    <?php include(TA_THEME_PATH . "/markup/partes/mas-leidas-especial.php");  ?>
    <?php include(TA_THEME_PATH . "/markup/partes/ultimas-ambientales.php");  ?>
    <?php include_once(TA_THEME_PATH . "/markup/partes/podes-leer.php");  ?>
</div>

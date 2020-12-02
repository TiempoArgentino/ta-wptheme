<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiempo Argentino</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@1&family=Merriweather:wght@900&family=Red+Hat+Display:wght@400;500;700;900&family=Caladea:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../bootstrap.css">
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <div class="container-fluid container-lg p-0 p-md-2">
        <div class="d-flex col-12 flex-column flex-lg-row align-items-start p-0">
            <div class="col-12 col-lg-8 p-0">
                <?php include_once('../../partes/articulo-simple.php');  ?>
                <?php include_once('../../partes/seamos-socios.php');  ?>
                <?php include_once('../../partes/tags.php');  ?>
                <?php include_once('../../partes/mira-tambien.php');  ?>
                <?php include_once('../../partes/audiovisual.php');  ?>
            </div>
            <div class="col-12 col-lg-4 p-0">
                <div class="d-flex flex-column flex-lg-column-reverse">
                    <?php include_once('../../partes/newsletter.php');  ?>
                    <?php include_once('../../partes/mas-leidas.php');  ?>
                </div>
                <div class="d-none d-lg-block">
                    <?php include_once('../../partes/taller-relacionado.php');  ?>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('../../partes/segun-tus-intereses.php');  ?>
    <div class="d-block d-md-none">
        <?php include_once('../../partes/taller-relacionado.php');  ?>
    </div>
    <?php include_once('../../partes/comentarios.php');  ?>
    <?php include_once('../../partes/pregunta-y-participa.php');  ?>
    <?php include_once('../../partes/conversemos.php');  ?>
    <?php include_once('../../partes/relacionados-tema.php');  ?>
    <?php include_once('../../partes/podes-leer.php');  ?>


</body>

</html>
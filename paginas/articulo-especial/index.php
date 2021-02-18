<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiempo Argentino</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@1&family=Merriweather:wght@900&family=Red+Hat+Display:wght@400;500;700;900&family=Caladea:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="../../js/bootstrap.min.js"></script>
</head>

<body>
    <?php include_once('../../partes/header.php');  ?>
    <div class="container-fluid container-lg p-0 ">
        <?php include_once('../../partes/articulo-especial.php');  ?>
        <div class="ta-context yellow-border">
            <?php include_once('../../partes/seamos-socios-fullwidth.php');  ?>
        </div>
        <?php include_once('../../partes/tags.php');  ?>
        <div class="d-flex flex-column flex-md-row">
            <?php include_once('../../partes/sponsor.php');  ?>

        </div>
    </div>
    <div class="ta-context dark-bg mt-3 d-none d-md-block">
        <?php include_once('../../partes/audiovisual-especial.php');  ?>
    </div>
    <div class="d-block d-md-none">
        <div class="container-md mb-2 p-0">
            <div class="separator"></div>
        </div>
        <?php include_once('../../partes/audiovisual.php');  ?>
    </div>
    <div class="container p-0 d-block d-md-none mt-3">
        <div class="line-height-0">
            <div class="separator m-0"></div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="ta-context newsletter-especial">
            <?php include_once('../../partes/newsletter-especial.php');  ?>
        </div>
    </div>
    </div>
    <div class="ta-context light-blue-bg mt-5">
        <?php include('../../partes/segun-tus-intereses.php');  ?>
    </div>
    <div class="container mt-3">
        <div class="line-height-0">
            <div class="separator m-0"></div>
        </div>
        <div class="ta-context talleres-especial">
            <?php include('../../partes/talleres.php');  ?>
        </div>
    </div>
    <div class="container-md mb-2 p-0">
        <div class="separator"></div>
    </div>
    <div class="container-md">
        <?php include_once('../../partes/comentarios.php');  ?>
    </div>
    <div class="container-md mb-2 p-0">
        <div class="separator"></div>
    </div>
    <div class="container-md">
        <?php include_once('../../partes/pregunta-y-participa.php');  ?>
    </div>
    <div class="container-md mb-2 p-0">
        <div class="separator"></div>
    </div>
    <div class="container-md">
        <?php include_once('../../partes/conversemos.php');  ?>
    </div>
    <div class="container-md p-0 line-height-0">
        <div class="separator"></div>
    </div>
    <div class="ta-context dark-blue-bg">
        <?php include_once('../../partes/relacionados-tema.php');  ?>
    </div>
    <div class="container-md p-0 line-height-0">
        <div class="separator"></div>
    </div>
    <div class="ta-context mas-leidas-especial">
        <?php include('../../partes/mas-leidas-especial.php');  ?>
    </div>
    <div class="container-md p-0 line-height-0">
        <div class="separator"></div>
    </div>
    <div class="ta-context light-blue-bg">
        <?php include('../../partes/ultimas-ambientales.php');  ?>
    </div>
    <div class="container-md p-0 line-height-0">
        <div class="separator"></div>
    </div>
    <div class="ta-context light-blue-bg">
        <?php include_once('../../partes/podes-leer.php');  ?>
    </div>
    <?php include_once('../../partes/footer.php');  ?>
</body>

</html>
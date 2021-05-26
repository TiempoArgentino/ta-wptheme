<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiempo Argentino</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@1&family=Merriweather:wght@900&family=Red+Hat+Display:wght@400;500;700;900&family=Caladea:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="/js/bootstrap.min.js"></script>
</head>

<body>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/header.php");  ?>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/articulo-especial.php");  ?>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/seamos-socios-fullwidth.php");  ?>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/tags.php");  ?>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/sponsor.php");  ?>
    <div class="d-none d-md-block">
        <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/audiovisual-especial.php");  ?>
    </div>
    <div class="d-block d-md-none">
        <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/audiovisual.php");  ?>
    </div>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/newsletter-especial.php");  ?>
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/partes/segun-tus-intereses.php");  ?>
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/partes/talleres.php");  ?>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/comentarios.php");  ?>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/pregunta-y-participa.php");  ?>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/conversemos.php");  ?>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/relacionados-tema.php");  ?>
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/partes/mas-leidas-especial.php");  ?>
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/partes/ultimas-ambientales.php");  ?>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/podes-leer.php");  ?>
    <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/partes/footer.php");  ?>
    <script src="/js/index.js"></script>
</body>

</html>

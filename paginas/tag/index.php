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
    <div class="container-fluid container-lg p-0 p-md-2">
        <?php include_once('../../partes/tag-info.php');  ?>
        <div class="d-flex flex-column flex-md-row-reverse">
            <div class="col-12 col-md-4 p-0">
                <?php include_once('../../partes/seamos-socios.php');  ?>
            </div>
            <div class="col-12 col-md-8 p-0">
                <?php include_once('../../partes/articulos-tag.php');  ?>
            </div>
        </div>
        <div class="btns-container">
            <div class="pagination d-none d-lg-flex justify-content-center">
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
            </div>
        </div>
    </div>
    <?php include_once('../../partes/footer.php');  ?>
</body>

</html>
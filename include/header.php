<?php
// -------------------------------------------------------------------
// ATTENTION : ne PAS mettre ../ avant les images/liens sur ce fichier
// -------------------------------------------------------------------
?>

<?php
global $titre;
global $urlstyle;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $titre; ?></title>

    <link href="style/global.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $urlstyle; ?>" rel="stylesheet">

    <link rel="icon" href="images/logo_favicon.jpg">
    <script src="javascript/global.js" defer></script>

    <!--bootstrap et leaflet-->
    <link href="node_modules/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="node_modules/leaflet/dist/leaflet.css">
    <script src="node_modules/leaflet/dist/leaflet.js"></script>
</head>
<body>


<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="images/logos/logosite.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            Bootstrap
        </a>
    </div>
</nav>
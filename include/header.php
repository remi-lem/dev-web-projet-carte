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

    <link rel="icon" href="images/logos/logoSite.png">

    <script src="konami/autrechose.js"></script>

    <!--bootstrap et leaflet-->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="node_modules/leaflet/dist/leaflet.css">
    <script src="node_modules/leaflet/dist/leaflet.js"></script>

    <link rel="stylesheet" href="node_modules/leaflet.markercluster/dist/MarkerCluster.css">
    <link rel="stylesheet" href="node_modules/leaflet.markercluster/dist/MarkerCluster.Default.css">
    <script src="node_modules/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
</head>
<body>


<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="images/logos/logoSite.png" alt="Logo" width="60" height="60">
            GaresÀVous!
        </a>
        <a href="user_account.php"><img id="logoAccount" alt="userAccount" src="images/logos/user.png" width="40" height="40"></a>
    </div>
</nav>
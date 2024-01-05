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

    <link href="styles/global.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $urlstyle; ?>" rel="stylesheet">

    <link rel="icon" href="images/logos/logoSite.png">

    <script src="konami/autrechose.js"></script>

    <!--dependencies-->
    <link rel="stylesheet" href="dependencies/bootstrap/bootstrap.min.css">
    <script src="dependencies/bootstrap/bootstrap.min.js"></script>

</head>
<body>


<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="images/logos/logoSite.png" alt="Logo" width="60" height="60">
            GaresÀVous! | Accueil
        </a>
        <a class="navbar-brand" href="user_account.php"><?php echo $_SESSION['Name'] ?? "Compte" ?>
            <img id="logoAccount" alt="userAccount" src="images/logos/user.png" width="40" height="40">
        </a>
    </div>
</nav>
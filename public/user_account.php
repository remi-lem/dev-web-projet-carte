<?php

session_start();

$titre = "Compte | GareÀVous";
$urlstyle = "styles/account.css";
require_once("include/header.php");

/*
//uncomment only for debugging
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
*/

$envFilePath = __DIR__ . '/.env';
$envContent = file_get_contents($envFilePath);
$envVariables = parse_ini_string($envContent);

$servernameDB = $envVariables['DB_SERV'];
$usernameDB = $envVariables['DB_USER'];
$passwordDB = $envVariables['DB_PASS'];
$nameDB = $envVariables['DB_NAME'];

// Create connection
try {
    $conn = new mysqli($servernameDB, $usernameDB, $passwordDB, $nameDB);
} catch (mysqli_sql_exception $e) {
    echo("<p class='alert alert-danger'>impossible de se connecter à la base de données</p>");
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['logout'])){
    $_SESSION = array();
}

if(isset($_GET['delete-account'])){
    $usernameDel = $_SESSION['Username'];
    $delFavStation = $conn->prepare("DELETE FROM FavouriteStations WHERE FavouriteStations.IdUser = (SELECT User.Id FROM User WHERE User.Surname = ?)");
    $delAccount = $conn->prepare("DELETE FROM User WHERE User.Id = (SELECT User.Id FROM User WHERE User.Surname = ?)");
    try {
        $delFavStation->bind_param("s", $usernameDel);
        $delFavStation->execute();
        $delAccount->bind_param("s", $usernameDel);
        $delAccount->execute();
        echo("<p class='alert alert-success'>Compte supprimé avec succès</p>");
    } catch (mysqli_sql_exception $e){
        echo("<p class='alert alert-danger'>Impossible de supprimer ce compte</p>");
    }
    $_SESSION = array();
}

if(isset($_GET['addFavId'])){
    $_SESSION['newFavId'] = $_GET['addFavId'];
}

if(isset($_GET['removeFavId'])){
    $_SESSION['removeFavId'] = $_GET['removeFavId'];
}
if(isset($_POST['Username'])){
    $_SESSION['Username'] = $_POST['Username'];
}
if(isset($_POST['Password'])){
    $_SESSION['Password'] = $_POST['Password'];
}
if(isset($_POST['newAddress'])){
    $_SESSION['newAddress'] = $_POST['newAddress'];
    $_POST['newAddress'] = null;
}


$name = $_POST['Name'] ?? null;
$username = $_SESSION['Username'] ?? null;
$password = $_SESSION['Password'] ?? null;

if(isset($name)){
    $addAccount = $conn->prepare("INSERT INTO User(Name, Surname, Password) VALUES (?, ?, ?)");
    try {
        $addAccount->bind_param("sss", $name, $username, $password);
        $addAccount->execute();
        echo("<p class='alert alert-success'>Utilisateur crée ! Vous pouvez vous connecter</p>");
    } catch (mysqli_sql_exception $e){
        echo("<p class='alert alert-danger'>Cet utilisateur existe déjà. Merci de choisir un nom/pseudo différent.</p>");
    }
    require_once("include/connection.php");
}
else {
    $login = $conn->prepare("SELECT U.Id, U.Name, U.Surname, U.Password FROM User U WHERE U.Surname = ? AND U.Password = ?");
    $login->bind_param("ss", $username, $password);
    $login->execute();
    $result = $login->get_result();

    if ($result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $IdUser = $row['Id'];
        }
        require_once("include/userConnected.php");
    } else {
        if(isset($username)){
            echo("<p class='alert alert-danger'>Mauvais identifiant/mot de passe</p>");
        }
        require_once("include/connection.php");
    }
}
?>


<?php
require_once("include/footer.php");
?>
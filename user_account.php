<?php
$titre = "Compte | GareÀVous";
$urlstyle = "style/account.css";
require_once("include/header.php");

session_start();

/*
// METTRE CA SEULEMENT POUR LE DEBUG
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
*/

$envFilePath = __DIR__ . '/.env';
$envContent = file_get_contents($envFilePath);
$envVariables = parse_ini_string($envContent);

$servername = $envVariables['DB_SERV'];
$username = $envVariables['DB_USER'];
$password = $envVariables['DB_PASS'];
$dbname = $envVariables['DB_NAME'];

// Create connection
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    echo("<p class='alert alert-danger'>impossible de se connecter à la base de données</p>");
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_GET['addFavId'])){
    $_SESSION['newFavId'] = $_GET['addFavId'] ?? null;
}

$name = $_POST['Name'] ?? null;
$username = $_POST['Username'] ?? null;
$password = $_POST['Password'] ?? null;

if(isset($name)){
    $addAccount = "INSERT INTO User(Name, Surname, Password) VALUES ('$name', '$username', '$password')";
    try {
        $result = $conn->query($addAccount);
        echo("<p class='alert alert-success'>Utilisateur crée ! Vous pouvez vous connecter</p>");
    } catch (mysqli_sql_exception $e){
        echo("<p class='alert alert-danger'>Cet utilisateur existe déjà. Merci de choisir un nom/pseudo différent.</p>");
    }
    require_once("include/connection.php");
}
else {
    $query = "SELECT U.Id, U.Name, U.Surname, U.Password FROM User U WHERE U.Surname = '$username' AND U.Password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $IdUser = mysqli_fetch_array($result)['Id'];
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
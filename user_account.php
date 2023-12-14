<?php
$titre = "Compte | GareÀVous";
$urlstyle = "style/account.css";
require_once("include/header.php"); // TODO : enlever le logo du compte utilisateur

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
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$IdUser = 1; //TODO changer par l'id de l'user qui est connecté

$sqlUserName = "SELECT U.Name FROM User U WHERE U.Id = $IdUser";
$resultSqlUserName = $conn->query($sqlUserName);

// Process all rows
while($row = mysqli_fetch_array($resultSqlUserName)) {
    $name = $row['Name'];
}

$sqlFavouriteStations = "SELECT F.IdStation FROM FavouriteStations F WHERE F.IdUser = $IdUser";
$resultSqlFavouriteStations = $conn->query($sqlFavouriteStations);

$favouriteStationsTable = '<table><thead><tr><td>Nom de la station</td></tr></thead><tbody>';

// Process all rows
while($row = mysqli_fetch_array($resultSqlFavouriteStations)) {
    $favouriteStationsTable .= "<tr><td>" . $row["IdStation"] . "</td></tr>";
}

$favouriteStationsTable .= "</tbody></table>";

$conn->close();

?>
    <div id="congtenu-compte">
        <h1>Bienvenue <?php echo($name)?> !</h1>
        <div id="favorite-gare">
            <h2>Mes gares préférées</h2>
                <?php echo $favouriteStationsTable ?>
            <button class="btn-light btn">Ajouter une gare</button>
        </div>
        <div id="train-schedule">
            <h2>Horaire des trains</h2>
            <ul>
                <li>TRAIN 1 - Horaire 1</li>
                <li>TRAIN 2 - Horaire 2</li>
                <li>TRAIN 3 - Retardé</li>
                <li>TRAIN 4 - Horaire 4</li>
            </ul>
        </div>
    </div>

<?php
require_once("include/footer.php");
?>
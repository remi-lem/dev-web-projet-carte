<?php
global $conn, $IdUser;

$newFavId = $_SESSION['newFavId'] ?? null;

$removeFavId = $_SESSION['removeFavId'] ?? null;

if(isset($newFavId)){
    $sqlAddFavId = "INSERT INTO FavouriteStations(IdUser, IdStation) VALUES ($IdUser, $newFavId)";
    try{
        $conn->query($sqlAddFavId);
        $_SESSION['newFavId'] = null;
    } catch (mysqli_sql_exception $e){
        echo("<p class='alert alert-danger'>Cette gare a déja été ajoutée.</p>");
        $_SESSION['newFavId'] = null;
    }
}

if(isset($removeFavId)){
    $sqlRmFavId = "DELETE FROM FavouriteStations WHERE FavouriteStations.IdStation = $removeFavId";
    try{
        $conn->query($sqlRmFavId);
        $_SESSION['removeFavId'] = null;
    } catch (mysqli_sql_exception $e){
        echo("<p class='alert alert-danger'>Impossible de supprimer cette gare</p>");
        $_SESSION['removeFavId'] = null;
    }
}

$sqlUserName = "SELECT U.Name FROM User U WHERE U.Id = $IdUser";
$resultSqlUserName = $conn->query($sqlUserName);

// Process all rows
while($row = mysqli_fetch_array($resultSqlUserName)) {
    $name = $row['Name'];
}

$sqlFavouriteStations = "SELECT F.IdStation FROM FavouriteStations F WHERE F.IdUser = $IdUser";
$resultSqlFavouriteStations = $conn->query($sqlFavouriteStations);

$favouriteStationsTable = '<table><thead><tr><td>Nom de la station</td><td>Supression</td></tr></thead><tbody>';

// Process all rows
while($row = mysqli_fetch_array($resultSqlFavouriteStations)) {
    $favouriteStationsTable .= "<tr><td>" . $row["IdStation"] . "</td><td><a href='user_account.php?removeFavId=" . $row["IdStation"] . "'>Supprimer</a></td></tr>";
    //TODO : mettre les noms des stations
}

$favouriteStationsTable .= "</tbody></table>";

$conn->close();

?>
<div id="congtenu-compte">
    <h1>Bienvenue <?php echo($name)?> !</h1>
    <div id="favorite-gare">
        <h2>Mes gares préférées</h2>
        <?php echo $favouriteStationsTable ?>
        <p>Pour ajouter une gare à vos favoris, allez sur <a href="index.php">la carte</a></p>
    </div>
    <div id="train-schedule">
        <h2>Horaire des trains</h2>
        <ul>
            <!--TODO-->
            <li>TRAIN 1 - Horaire 1</li>
            <li>TRAIN 2 - Horaire 2</li>
            <li>TRAIN 3 - Retardé</li>
            <li>TRAIN 4 - Horaire 4</li>
        </ul>
    </div>
    <div id="logout">
        <a href="user_account.php?logout=true" class="btn btn-outline-danger" id="btn-logout">Se déconnecter</a>
    </div>
    <div id="delete-account">
        <a href="user_account.php?delete-account=true" class="btn btn-danger" id="btn-rm-account">Supprimer son compte</a>
    </div>
</div>
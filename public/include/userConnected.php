<?php
global $conn, $IdUser;

$newFavId = $_SESSION['newFavId'] ?? null;

$removeFavId = $_SESSION['removeFavId'] ?? null;

//ajout de gare favorite
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

//supression de gare favorite
if(isset($removeFavId)){
    $sqlRmFavId = "DELETE FROM FavouriteStations WHERE FavouriteStations.IdStation = $removeFavId AND FavouriteStations.IdUser = $IdUser";
    try{
        $conn->query($sqlRmFavId);
        $_SESSION['removeFavId'] = null;
    } catch (mysqli_sql_exception $e){
        echo("<p class='alert alert-danger'>Impossible de supprimer cette gare</p>");
        $_SESSION['removeFavId'] = null;
    }
}

//récupération du nom d'utilisateur
$sqlUserName = "SELECT U.Name FROM User U WHERE U.Id = $IdUser";
$resultSqlUserName = $conn->query($sqlUserName);

while($row = mysqli_fetch_array($resultSqlUserName)) {
    $name = $row['Name'];
}

//construction du tableau des gares favorites
$sqlFavouriteStations = "SELECT F.IdStation FROM FavouriteStations F WHERE F.IdUser = $IdUser";
$resultSqlFavouriteStations = $conn->query($sqlFavouriteStations);

$favouriteStationsTable = '<table class="table"><thead><tr><th scope="col">Nom de la station</th><th scope="col">Supression</th><th scope="col">Voir les prochains départs</th></tr></thead><tbody>';

$geojson_data = file_get_contents("data/liste-des-gares.geojson");
$geojson = json_decode($geojson_data, true);

while($row = mysqli_fetch_array($resultSqlFavouriteStations)) {
    $stationShowName = $row["IdStation"];
    foreach ($geojson['features'] as $feature) {
        $properties = $feature['properties'];
        $code_uic = $properties['code_uic'];
        if ($code_uic === $row["IdStation"]) {
            $stationShowName = $properties['libelle'];
            break;
        }
    }
    $getNextDeparturesURL = "https://www.sncf.com/fr/gares/details/OCE" . $row["IdStation"] . "/departs-arrivees/gl/departs";
    $favouriteStationsTable .= "<tr><td>" . $stationShowName . "</td><td><a href='user_account.php?removeFavId=" .
        $row["IdStation"] . "'>Supprimer</a></td><td><a href='$getNextDeparturesURL' target='_blank'>Prochains départs</a></td></tr>";
}

$favouriteStationsTable .= "</tbody></table>";

//mise à jour de l'adresse
$newAddress = $_SESSION['newAddress'];
if(isset($newAddress) && $newAddress !== ""){
    $_SESSION['newAddress'] = null;
    $sqlUpdateAddress = "UPDATE User U SET U.Address = '$newAddress' WHERE U.Id = $IdUser";
    try {
        $result = $conn->query($sqlUpdateAddress);
        echo("<p class='alert alert-success'>Adresse modifiée !</p>");
    } catch (mysqli_sql_exception $e){
        echo("<p class='alert alert-danger'>Impossible de mettre a jour l'adresse.</p>");
    }
}

//récupération de l'adresse de l'utilisateur
$address = "";
$sqlAdress = "SELECT U.Address FROM User U WHERE U.Id = $IdUser";
$resultSqlAdress = $conn->query($sqlAdress);
while($row = mysqli_fetch_array($resultSqlAdress)) {
    $address = $row['Address'];
}
if($address == ""){
    $address = "Aucune adresse définie";
}

//fermeture de la connection
$conn->close();

?>
<div id="contenu-compte">
    <h1>Bienvenue <?php echo($name)?> !</h1>
    <div id="favorite-gare">
        <h2>Mes gares préférées</h2>
        <?php echo $favouriteStationsTable ?>
        <p>Pour ajouter une gare à vos favoris, allez sur <a href="index.php">la carte</a>.</p>
    </div>
    <div id="home">
        <h2>Mon domicile</h2>
        <div class="mb-3 col-md-7 col-lg-6">
            <form action="user_account.php" method="post">
                <label for="newAddress">Adresse :</label>
                <input id="newAddress" name="newAddress" type="text" class="form-control" placeholder="<?php echo($address)?>">
                <button class="btn btn-outline-secondary" type="submit">Modifier</button>
            </form>
        </div>
    </div>
    <div id="gestionCompte">
        <a href="user_account.php?logout=true" class="btn btn-outline-danger" id="btn-logout">Se déconnecter</a>
        <button type="button" class="btn btn-primary btn-danger" onclick="showConfirmationDialog()">
            Supprimer mon compte
        </button>
    </div>
    <div id="confirmationDialog" class="alert alert-danger" role="alert">
        <p>Êtes-vous sûr de vouloir supprimer votre compte, et toutes les données associées ?</p>
        <button type="button" class="btn btn-secondary" onclick="cancelDeletion()">Annuler</button>
        <a href="user_account.php?delete-account=true" class="btn btn-primary btn-danger" id="btn-rm-account">Confirmer</a>
    </div>
    <script>
        function showConfirmationDialog() {
            document.getElementById('confirmationDialog').style.display = 'block';
        }

        function cancelDeletion() {
            document.getElementById('confirmationDialog').style.display = 'none';
        }
    </script>
</div>
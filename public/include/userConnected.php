<?php
global $conn, $IdUser;

$newFavId = $_SESSION['newFavId'] ?? null;

$removeFavId = $_SESSION['removeFavId'] ?? null;

//ajout de gare favorite
if(isset($newFavId)){
    $sqlAddFavId = $conn->prepare("INSERT INTO favourite_stations(id_user_id, id_station) VALUES (?, ?)");
    try{
        $sqlAddFavId->bind_param("ii", $IdUser, $newFavId);
        $sqlAddFavId->execute();
        $_SESSION['newFavId'] = null;
    } catch (mysqli_sql_exception $e){
        echo("<p class='alert alert-danger'>Cette gare a déja été ajoutée.</p>");
        $_SESSION['newFavId'] = null;
    }
}

//supression de gare favorite
if(isset($removeFavId)){
    $sqlRmFavId = $conn->prepare("DELETE FROM favourite_stations WHERE favourite_stations.id_station = ? AND favourite_stations.id_user_id = ?");
    try{
        $sqlRmFavId->bind_param("ii", $removeFavId, $IdUser);
        $sqlRmFavId->execute();
        $_SESSION['removeFavId'] = null;
    } catch (mysqli_sql_exception $e){
        echo("<p class='alert alert-danger'>Impossible de supprimer cette gare</p>");
        $_SESSION['removeFavId'] = null;
    }
}

//récupération du nom d'utilisateur
$sqlUserName = $conn->prepare("SELECT U.Name FROM user U WHERE U.Id = ?");
$sqlUserName->bind_param("i", $IdUser);
$sqlUserName->execute();
$resultSqlUserName = $sqlUserName->get_result();

while($row = mysqli_fetch_array($resultSqlUserName)) {
    $name = $row['Name'];
}

$_SESSION['Name'] = $name;

//construction du tableau des gares favorites
$sqlFavouriteStations = $conn->prepare("SELECT F.id_station FROM favourite_stations F WHERE F.id_user_id = ?");
$sqlFavouriteStations->bind_param("i", $IdUser);
$sqlFavouriteStations->execute();
$resultSqlFavouriteStations = $sqlFavouriteStations->get_result();

$favouriteStationsTable = '<table class="table"><thead><tr><th scope="col">Nom de la station</th><th scope="col">Supression</th><th scope="col">Voir les prochains départs</th></tr></thead><tbody>';

$geojson_data = file_get_contents("data/liste-des-gares.geojson");
$geojson = json_decode($geojson_data, true);

while($row = mysqli_fetch_array($resultSqlFavouriteStations)) {
    $stationShowName = $row["id_station"];
    foreach ($geojson['features'] as $feature) {
        $properties = $feature['properties'];
        $code_uic = $properties['code_uic'];
        if ($code_uic == $row["id_station"]) {
            $stationShowName = $properties['libelle'];
            break;
        }
    }
    $getNextDeparturesURL = "https://www.sncf.com/fr/gares/details/OCE" . $row["id_station"] . "/departs-arrivees/gl/departs";
    $favouriteStationsTable .= "<tr><td>" . $stationShowName . "</td><td><a href='user_account.php?removeFavId=" .
        $row["id_station"] . "'>Supprimer</a></td><td><a href='$getNextDeparturesURL' target='_blank'>Prochains départs</a></td></tr>";
}

$favouriteStationsTable .= "</tbody></table>";

//mise à jour de l'adresse
$newAddress = $_SESSION['newAddress'] ?? null;
if(isset($newAddress) && $newAddress !== ""){
    $_SESSION['newAddress'] = null;
    $sqlUpdateAddress = $conn->prepare("UPDATE user U SET U.Address = ? WHERE U.Id = ?");
    try {
        $sqlUpdateAddress->bind_param("si", $newAddress, $IdUser);
        $sqlUpdateAddress->execute();
        echo("<p class='alert alert-success'>Adresse modifiée !</p>");
    } catch (mysqli_sql_exception $e){
        echo("<p class='alert alert-danger'>Impossible de mettre a jour l'adresse.</p>");
    }
}

//récupération de l'adresse de l'utilisateur
$address = "";
$sqlAdress = $conn->prepare("SELECT U.Address FROM user U WHERE U.Id = ?");
$sqlAdress->bind_param("i", $IdUser);
$sqlAdress->execute();
$resultSqlAdress = $sqlAdress->get_result();
while($row = mysqli_fetch_array($resultSqlAdress)) {
    $address = $row['Address'];
    $_SESSION['address'] = $address;
}
if($address == ""){
    $address = "Aucune adresse définie";
    $_SESSION['address'] = null;
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
                <button class="btn btn-outline-secondary" type="submit">Valider</button>
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
<?php
$titre = "Compte | GareÀVous";
$urlstyle = "style/account.css";
require_once("include/header.php"); // TODO : enlever le logo du compte utilisateur
?>
    <div id="congtenu-compte">
        <div id="favorite-gare">
            <h2>Mes gares préférées</h2>
            <ul>
                <li>GARE 1</li>
                <li>GARE 2</li>
                <li>GARE 3</li>
                <li>GARE 4</li>
            </ul>
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
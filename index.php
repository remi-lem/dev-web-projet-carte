<?php
$titre = "Accueil | GaresÀVous";
$urlstyle = "style/index.css";
require_once("include/header.php");
?>

<script src="carte/leaflet.js" defer></script>
<div id="mapContainer">
    <div id="map"></div>
</div>

<?php
require_once("include/footer.php");
?>
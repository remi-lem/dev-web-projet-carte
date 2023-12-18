<?php
$titre = "Konami | GaresÀVous";
$urlstyle = "konami/konami.css";
require_once("include/header.php");
?>

<script src="konami/konami.js" defer></script>

<div class="content konami-game">
    <h1>Bataille navale</h1>
    <div class="game-container">
        <div class="gameboard">
            <table id="board"></table>
        </div>
        <div class="messages">
            <p id="message"></p>
        </div>
    </div>
</div>


<?php
require_once("include/footer.php");
?>

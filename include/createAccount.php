<?php
global $conn, $password, $name, $username;
$query = "INSERT INTO User(Name, Surname, Password) VALUES ('$name', '$username', '$password')";

try {
    $result = $conn->query($query);
} catch (mysqli_sql_exception $e){
    echo("<p class='alert alert-danger'>Cet utilisateur existe déjà. Merci de choisir un nom/pseudo différent.</p>");
    //TODO reafficher le form
    exit;
}
?>

<h2>Utilisateur crée ! Vous pouvez retourner à la <a href="user_account.php">page de connection</a></h2>

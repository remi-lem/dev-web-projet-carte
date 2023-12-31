<div class="flex-container flex-wrap">
    <div class="flex-item">
        <h1>Page de connexion</h1>
        <form action="user_account.php" method="post">
            <label for="username">Pseudonyme :</label>
            <input class="form-control" type="text" id="username" name="Username" required>
            <br>
            <label for="password">Mot de passe :</label>
            <input class="form-control" type="password" id="password" name="Password" required>
            <br>
            <button class="form-control" type="submit">Valider</button>
        </form>
    </div>
    <div class="flex-item">
        <h1>Création de compte</h1>
        <form action="user_account.php" method="post">
            <label for="name">Prénom :</label>
            <input class="form-control" type="text" id="name" name="Name" required>
            <br>
            <label for="username">Pseudonyme :</label>
            <input class="form-control" type="text" id="username" name="Username" required>
            <br>
            <label for="password">Mot de passe :</label>
            <input class="form-control" type="password" id="password" name="Password" required>
            <br>
            <button class="form-control" type="submit">Valider</button>
    </div>
</div>
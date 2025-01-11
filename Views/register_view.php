

<div class="register-container">
    <form action="index.php?action=register" method="POST">
        <h1>Inscription</h1>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirmez le mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" name="submit">Créer un compte</button>
    </form>
</div>
<?php include 'footer.php'; ?>

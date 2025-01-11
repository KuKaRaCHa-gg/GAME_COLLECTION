<?php include 'Controllers/NavBar.php';
require_once 'Models/fonctionDB.php';
require_once 'Models/User.php';
$pdo = connexion(); ?>
<div class="login-container">
    <form action="index.php?action=login" method="POST">
        <h1>Connexion</h1>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
        <a href="index.php?action=register">Pas encore inscrit ? Créez un compte</a>
    </form>
</div>
<?php include 'footer.php'; ?>

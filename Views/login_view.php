<?php include 'Controllers/NavBar.php';
require_once 'Models/fonctionDB.php';
require_once 'Models/User.php';
$pdo = connexion(); ?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
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
<?php 

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    loginUser($pdo,$email, $password);
}

include 'footer.php'; ?>

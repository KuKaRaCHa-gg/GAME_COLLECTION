<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="login-container">
    <form action="login" method="POST">
        <h1>Connexion</h1>
        <p> <?php echo htmlspecialchars($message)?></p>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
        <a href="register">Pas encore inscrit ? Créez un compte</a>
    </form>
</div>
    
</body>
</html>

<?php include 'footer.php'; ?>

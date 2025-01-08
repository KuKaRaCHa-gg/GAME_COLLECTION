<?php
require_once 'Models/fonctionDB.php';
require_once 'Models/User.php';
$pdo = connexion(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<br>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="profilContainer">
    <div class="profil">
    <h2>Mon Profil</h2>
    <br>
    <br>


    <?php 
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'Modifier mon profile') {
            getUserToModif($pdo, $_SESSION['user_id']);
        } elseif ($_POST['submit'] == 'Supprimer mon compte') {
            header('Location: index.php?action=deleteProfile');
        } elseif ($_POST['submit'] == 'Se déconnecter') {
            session_destroy();
            header('Location: index.php?action=logout');
            exit();
        }
    } else {
    $users = getUser($pdo, $_SESSION['user_id']); ?>
    <br>

    <p> Nom : <?php echo htmlspecialchars($users['nom_user']); ?></p>
    <p> Prénom : <?php echo htmlspecialchars($users['pren_user']); ?></p>
    <p> Email : <?php echo htmlspecialchars($users['mail_user']); ?></p>

<form class="formProfil" action="" method="post">
    <input type="submit" name="submit" value="Modifier mon profile"> <br>
    <input type="submit" name="submit" value="Supprimer mon compte"> <br>
    <input type="submit" name="submit" value="Se déconnecter"> <br>
</form>

    <?php }
     ?>
    </div>
    </div>
    
</body>
</html>
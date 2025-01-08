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
    <div class="profilContainer">
    <div class="profil">
    <h1 class="titreProfil">Mon Profil</h1>

    <?php 
    $status = '';
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'MODIFIER MON PROFILE') {
            getUserToModif($pdo, $_SESSION['user_id']);
        } elseif ($_POST['submit'] == 'SUPPRIMER MON COMPTE') {
            deleteUser($pdo, $_SESSION['user_id']);
        } elseif ($_POST['submit'] == 'SE DÉCONNECTER') {
            logout();
        }
    } elseif (empty($_POST['submit']) || $status == 'modif') {
    $users = getUser($pdo, $_SESSION['user_id']); ?>

    <p class="profilTexte"> Nom : <?php echo htmlspecialchars($users['nom_user']); ?></p>
    <p class="profilTexte"> Prénom : <?php echo htmlspecialchars($users['pren_user']); ?></p>
    <p class="profilTexte"> Email : <?php echo htmlspecialchars($users['mail_user']); ?></p>

<form class="formProfil" action="" method="post">
    <input type="submit" name="submit" value="MODIFIER MON PROFILE" class="boutonProfil"> <br>
    <input type="submit" name="submit" value="SUPPRIMER MON COMPTE" class="boutonProfil"> <br>
    <input type="submit" name="submit" value="SE DÉCONNECTER" class="boutonProfil"> <br>
</form>

    <?php }
     ?>
    </div>
    </div>
    
</body>
</html>
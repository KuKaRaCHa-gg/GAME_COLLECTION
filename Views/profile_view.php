<?php
require_once 'Models/fonctionDB.php';
require_once 'Models/User.php';
?>
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
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'MODIFIER MON PROFILE') {
            $row = getUser($pdo, $_SESSION['user_id']);
            ?>
            <br>
            <form action="" method="post" class="formProfil">
        
            <label for="nom_user">Nom :</label><br>
            <input type="text" name="nom_user" value="<?php echo htmlspecialchars($row['nom_user']) ?>"><br>
        
            <label for="pren_user">Prénom :</label><br>
            <input type="text" name="pren_user" value=<?php echo htmlspecialchars($row['pren_user']) ?>><br>
        
            <label for="mail_user">Email :</label><br>
            <input type="text" name="mail_user" value=<?php echo htmlspecialchars($row['mail_user']) ?>><br>
        
            <label for="mdp_user">Mot de passe :</label><br>
            <input type="password" name="mdp" ><br>
            <label for="mdp_user">Confirmer le mot de passe :</label><br>
            <input type="password" name="mdp2" ><br>
        
            <input type="submit" name="submit" value="MODIFIER" class="boutonProfil"><br>
            <input type="submit" name="submit" value="SUPPRIMER MON COMPTE" class="boutonProfil"><br>
            <input type="submit" name="submit" value="SE DÉCONNECTER" class="boutonProfil"><br>
            </form>
            <?php
        } elseif ($_POST['submit'] == 'SUPPRIMER MON COMPTE') {
            deleteUser($pdo, $_SESSION['user_id']);
            exit();
        } elseif ($_POST['submit'] == 'SE DÉCONNECTER') {
            logout();
        }
     elseif ($_POST['submit'] == 'MODIFIER') {
        gestionMDP($pdo, $_SESSION['user_id'], $_POST['mdp'], $_POST['mdp2'], $_POST['nom_user'], $_POST['pren_user'], $_POST['mail_user']);
        exit();
    } }else {
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
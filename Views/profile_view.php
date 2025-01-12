<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="contentContainer">
    <div class="toLeft">
    <h1 class="titreProfil">Mon Profil</h1>

    <?php 
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'MODIFIER MON PROFILE') {
            ?>
            <br>
            <form action="" method="post" class="formDefaut">
        
            <label for="nom_user" class="labelProfil">Nom :</label><br>
            <input type="text" name="nom_user" value="<?php echo htmlspecialchars($users['nom_user']) ?>"><br>
        
            <label for="pren_user" class="labelProfil">Prénom :</label><br>
            <input type="text" name="pren_user" value=<?php echo htmlspecialchars($users['pren_user']) ?>><br>
        
            <label for="mail_user" class="labelProfil">Email :</label><br>
            <input type="email" id=email name="mail_user" value=<?php echo htmlspecialchars($users['mail_user']) ?>><br>
        
            <label for="mdp_user" class="labelProfil">Mot de passe :</label><br>
            <input type="password" name="mdp" ><br>
            <label for="mdp_user" class="labelProfil">Confirmer le mot de passe :</label><br>
            <input type="password" name="mdp2" ><br>
        
            <input type="submit" name="submit" value="MODIFIER" class="boutonProfil"><br>
            <input type="submit" name="submit" value="SUPPRIMER MON COMPTE" class="boutonProfil"><br>
            <input type="submit" name="submit" value="SE DÉCONNECTER" class="boutonProfil"><br>
            </form>
            <?php
    } }else { ?>

        <p class="profilTexte"> Nom : <?php echo htmlspecialchars($users['nom_user']); ?></p>
        <p class="profilTexte"> Prénom : <?php echo htmlspecialchars($users['pren_user']); ?></p>
        <p class="profilTexte"> Email : <?php echo htmlspecialchars($users['mail_user']); ?></p>

        <form class="formDefaut" action="" method="post">
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
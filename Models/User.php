<?php



function getUser($pdo, $id)
{
    $query = $pdo->prepare("SELECT * FROM UTILISATEUR WHERE id_user = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo '<br>';
    echo '<form action="" method="post">';

    echo '<label for="nom_user">Nom</label><br>';
    echo '<input type="text" name="nom_user" value="' . htmlspecialchars($row['nom_user']) . '"><br>';

    echo '<label for="pren_user">Prénom</label><br>';
    echo '<input type="text" name="pren_user" value="' . htmlspecialchars($row['pren_user']) . '"><br>';

    echo '<label for="mail_user">Email</label><br>';
    echo '<input type="text" name="mail_user" value="' . htmlspecialchars($row['mail_user']) . '"><br>'; 

    echo '<label for="mdp_user">Mot de passe</label><br>';
    echo '<input type="password" name="mdp_user" value=""><br>';
    echo '<label for="mdp_user">Confirmer le mot de passe</label><br>';
    echo '<input type="password" name="mdp_user" value=""><br>';

    echo '<input type="submit" name="submit" value="Modifier"><br>';
    echo '<input type="submit" name="submit" value="Supprimer mon compte"><br>';
    echo '<input type="submit" name="submit" value="Se déconnecter"><br>';
    echo '</form>';
}
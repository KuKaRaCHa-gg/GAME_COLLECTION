<?php


function loginUser($pdo, $email, $password)
{
    $query = $pdo->prepare("SELECT * FROM UTILISATEUR WHERE mail_user = :email");
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        if (password_verify($password, $row['mdp_user'])) {
            $_SESSION['user_id'] = $row['id_user'];
            header("Location: index.php?action=home");
            exit();
        } else {
            echo 'Mot de passe incorrect';
        }
    } else {
        echo 'Email incorrect';
    }
}


function createUser($pdo, $nom, $prenom, $email, $password)
{
    $nom = strtoupper($nom);
    $query = $pdo->prepare("SELECT * FROM UTILISATEUR WHERE mail_user = :email");
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo 'Un utilisateur avec cette email existe deja';
    } else {
        $mdp = password_hash($password, PASSWORD_DEFAULT);
        $query = $pdo->prepare("INSERT INTO UTILISATEUR (nom_user, pren_user, mail_user, mdp_user) VALUES (:nom, :prenom, :email, :mdp)");
        $query->bindParam(':nom', $nom, PDO::PARAM_STR);
        $query->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        $query->execute();
        header("Location: index.php?action=login");
        exit();
    }
}


function getPrenom($pdo, $id)
{
    $query = $pdo->prepare("SELECT pren_user FROM UTILISATEUR WHERE id_user = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    return $row['pren_user'];
}

function getUser($pdo, $id){
    $query = $pdo->prepare("SELECT * FROM UTILISATEUR WHERE id_user = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    return $row;
}


function getUserToModif($pdo, $id)
{
    $query = $pdo->prepare("SELECT * FROM UTILISATEUR WHERE id_user = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo '<br>';
    echo '<form action="" method="post" class="formProfil">';

    echo '<label for="nom_user">Nom :</label><br>';
    echo '<input type="text" name="nom_user" value="' . htmlspecialchars($row['nom_user']) . '"><br>';

    echo '<label for="pren_user">Prénom :</label><br>';
    echo '<input type="text" name="pren_user" value="' . htmlspecialchars($row['pren_user']) . '"><br>';

    echo '<label for="mail_user">Email :</label><br>';
    echo '<input type="text" name="mail_user" value="' . htmlspecialchars($row['mail_user']) . '"><br>'; 

    echo '<label for="mdp_user">Mot de passe :</label><br>';
    echo '<input type="password" name="mdp" ><br>';
    echo '<label for="mdp_user">Confirmer le mot de passe :</label><br>';
    echo '<input type="password" name="mdp2" ><br>';

    echo '<input type="submit" name="submit" value="MODIFIER" class="boutonProfil"><br>';
    echo '<input type="submit" name="submit" value="SUPPRIMER MON COMPTE" class="boutonProfil"><br>';
    echo '<input type="submit" name="submit" value="SE DÉCONNECTER" class="boutonProfil"><br>';
    echo '</form>';

    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'MODIFIER') {
            gestionMDP($pdo, $id, $_POST['mdp'], $_POST['mdp2'], $_POST['nom_user'], $_POST['pren_user'], $_POST['mail_user']);
        } 
        elseif ($_POST['submit'] == 'SUPPRIMER MON COMPTE') {
            deleteUser($pdo, $id);
            exit();
        } elseif ($_POST['submit'] == 'SE DÉCONNECTER') {
            logout();
        }
    }
}

function logout()
{
    session_destroy();
    header("Location: index.php?action=login");
    exit();
}

function deleteUser($pdo, $id)
{
    $query = $pdo->prepare("DELETE FROM UTILISATEUR WHERE id_user = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    header("Location: index.php?action=login");
    exit();
}

function gestionMDP($pdo, $id, $mdp, $mdp2, $nom, $prenom, $email)
{
    
    if ($mdp == "") {
        $sql = "UPDATE UTILISATEUR SET nom_user = :nom_user, pren_user = :pren_user, mail_user = :mail_user WHERE id_user = :id";
        $query = $pdo->prepare($sql);
        $query->bindParam(':nom_user', $nom, PDO::PARAM_STR);
        $query->bindParam(':pren_user', $prenom, PDO::PARAM_STR);
        $query->bindParam(':mail_user', $email, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $status = 'modif';
        header("Location: index.php?action=profile");
        exit();
    } elseif ($mdp == $mdp2) {
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        $query = $pdo->prepare("UPDATE UTILISATEUR SET nom_user = :nom_user, pren_user = :pren_user, mail_user = :mail_user, mdp_user = :mdp_user WHERE id_user = :id");
        $query->bindParam(':nom_user', $nom, PDO::PARAM_STR);
        $query->bindParam(':pren_user', $prenom, PDO::PARAM_STR);
        $query->bindParam(':mail_user', $email, PDO::PARAM_STR);
        $query->bindParam(':mdp_user', $mdp, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $status = 'modif';
        header("Location: index.php?action=profile");
        exit();
    } else {
        echo 'Les mots de passe ne correspondent pas';
    }
}
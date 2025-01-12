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
            header("Location: home");
            exit();
        } else {
            return 'Mot de passe incorrect';
        }
    } else {
        return 'Email incorrect';
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
    }
}

function verifiAdresseMail($pdo, $email)
{
    $query = $pdo->prepare("SELECT * FROM UTILISATEUR WHERE mail_user = :email");
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        return true;
    } else {
        return false;
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

function logout()
{
    session_destroy();
    header("Location: login");
    exit();
}

function deleteUser($pdo, $id)
{
    $sql = $pdo->prepare("SELECT * FROM LIBRARY WHERE id_user = :id");
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $query = $pdo->prepare("DELETE FROM LIBRARY WHERE id_user = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
    }
    $query = $pdo->prepare("DELETE FROM UTILISATEUR WHERE id_user = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    session_destroy();
    header("Location: login");
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
        $_POST['submit'] = '';
        header("Location: profile");
        exit();
    } elseif ($mdp == $mdp2) {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $query = $pdo->prepare("UPDATE UTILISATEUR SET nom_user = :nom_user, pren_user = :pren_user, mail_user = :mail_user, mdp_user = :mdp_user WHERE id_user = :id");
        $query->bindParam(':nom_user', $nom, PDO::PARAM_STR);
        $query->bindParam(':pren_user', $prenom, PDO::PARAM_STR);
        $query->bindParam(':mail_user', $email, PDO::PARAM_STR);
        $query->bindParam(':mdp_user', $mdp, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $_POST['submit'] = '';
        header("Location: profile");
        exit();
    } else {
        $_POST['submit'] = 'MODIFIER MON PROFILE';
        echo 'Les mots de passe ne correspondent pas';

    }

}
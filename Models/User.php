<?php



function getUser($pdo)
{
    $query = $pdo->prepare("SELECT * FROM UTILISATEUR");
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo '<br>';
    echo $row['nom_user'] . '<br>';
    echo $row['pren_user'] . '<br>';
    echo $row['mail_user'] . '<br>';
}
<?php

require 'fonctionDB.php';



function getUser()
{
    $pdo = connexion();
    $query = "SELECT * FROM UTILISATEUR";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
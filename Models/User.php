<?php

require 'fonctionDB.php';

$mysqli = connexion();

function getUser()
{
    global $mysqli;
    $query = "SELECT * FROM UTILISATEUR";
    $result = $mysqli->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}
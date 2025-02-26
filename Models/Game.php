<?php 

function getAllGames($pdo) {
    $query = "SELECT * FROM GAME";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

function addGameToLibrary($pdo, $id_user, $game) {
    $query = "INSERT INTO LIBRARY (id_user, id_game, time_game) VALUES (:id_user, :id_game, 0)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id_user' => $id_user, ':id_game' => $game]);
}

function verifyGame($pdo, $id_user, $game) {
    $query = "SELECT * FROM LIBRARY WHERE id_user = :id_user AND id_game = :id_game";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id_user' => $id_user, ':id_game' => $game]);
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        return true;
    } else {
        return false;
    }
}

function searchGame($pdo, $search) {
    $query = "SELECT * FROM GAME WHERE nom_game = :search";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':search' => $search]);
    return $stmt->fetchAll();
}

function addGame($pdo, $nom_game, $edit_game, $release_game, $type_plateforme, $desc_game, $url_cover_game, $url_site_game) {
    $query = "INSERT INTO GAME (nom_game, edit_game, release_game, type_plateforme, desc_game, url_cover_game, url_site_game) VALUES (:nom_game, :edit_game, :release_game, :type_plateforme, :desc_game, :url_cover_game, :url_site_game)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':nom_game' => $nom_game, ':edit_game' => $edit_game, ':release_game' => $release_game, ':type_plateforme' => $type_plateforme, ':desc_game' => $desc_game, ':url_cover_game' => $url_cover_game, ':url_site_game' => $url_site_game]);
}




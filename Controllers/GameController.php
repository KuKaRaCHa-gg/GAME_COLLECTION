<?php

class GameController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour rechercher un jeu
    public function searchGame($searchGame) {
        $stmt = $this->pdo->prepare("SELECT * FROM GAME WHERE nom_game LIKE :search_game");
        $stmt->execute([':search_game' => "%$searchGame%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour ajouter un jeu
    public function addGame($nomGame, $editGame, $releaseGame, $plateformes, $descGame, $urlCover, $urlSite) {
        $stmt = $this->pdo->prepare("
            INSERT INTO GAME (nom_game, edit_game, release_game, type_plateforme, desc_game, url_cover_game, url_site_game)
            VALUES (:nom_game, :edit_game, :release_game, :type_plateforme, :desc_game, :url_cover_game, :url_site_game)
        ");
        $stmt->execute([
            ':nom_game' => $nomGame,
            ':edit_game' => $editGame,
            ':release_game' => $releaseGame,
            ':type_plateforme' => $plateformes,
            ':desc_game' => $descGame,
            ':url_cover_game' => $urlCover,
            ':url_site_game' => $urlSite
        ]);
    }
}

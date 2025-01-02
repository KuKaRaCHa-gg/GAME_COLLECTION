<?php

class GameController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function checkIfGameExists($nomGame) {
        $stmt = $this->pdo->prepare("SELECT * FROM GAME WHERE nom_game = :nom_game");
        $stmt->execute([':nom_game' => $nomGame]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }
    
    // Méthode pour rechercher un jeu
    public function searchGame($searchGame) {
        $stmt = $this->pdo->prepare("SELECT * FROM GAME WHERE nom_game LIKE :search_game");
        $stmt->execute([':search_game' => "%$searchGame%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour ajouter un jeu
    public function addGame($nomGame, $editGame, $releaseGame, $plateformes, $descGame, $urlCover, $urlSite) {
        // Vérifier si le jeu existe déjà
        $stmt = $this->pdo->prepare("SELECT * FROM GAME WHERE nom_game = :nom_game");
        $stmt->execute([':nom_game' => $nomGame]);
    
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return "Erreur : Le jeu \"$nomGame\" existe déjà dans la base de données.";
        }
    
        // Ajouter le jeu
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
    
        return "Le jeu \"$nomGame\" a été ajouté avec succès !";
    }
    
    
}

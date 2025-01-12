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
    public function addGame($data, $id_user) {
        $nomGame = htmlspecialchars($data['nom_game']);
        $editGame = htmlspecialchars($data['edit_game']);
        $releaseGame = htmlspecialchars($data['release_game']);
        $plateformes = isset($data['plateformes']) ? implode(', ', $data['plateformes']) : '';
        $descGame = htmlspecialchars($data['desc_game'] ?? '');
        $urlCover = htmlspecialchars($data['url_cover_game']);
        $urlSite = htmlspecialchars($data['url_site_game']);
    
        // Vérifier si le jeu existe déjà
        if ($this->checkIfGameExists($nomGame)) {
            return "Erreur : Le jeu \"$nomGame\" existe déjà dans la base de données.";
        }
        addGame($this->pdo, $nomGame, $editGame, $releaseGame, $plateformes, $descGame, $urlCover, $urlSite);
        
        addGameToLibrary($this->pdo, $id_user, $this->pdo->lastInsertId());
    
        header("Location: home");
    }
    
    
    
}

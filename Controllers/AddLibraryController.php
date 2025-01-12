<?php 

class AddLibraryController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addGame($data) {
        if (isset($data['add_game'])) {
            if (verifyGame($this->pdo, $_SESSION['user_id'], $data['id_game']) == true) {
                $message = 'Le jeu ' . htmlspecialchars($data['nom_game']) . ' est déjà dans votre bibliothèque';
                return $message;
            } else {
                addGameToLibrary($this->pdo, $_SESSION['user_id'], $data['id_game']);
                $message = 'Le jeu ' . htmlspecialchars($data['nom_game']) . ' a bien été ajouté à votre bibliothèque';
                return $message;
            }
        }
    }

    public function searchGame($data) {
        if (isset($data['search_action']) && $data['search_game'] != '') {
            $games = searchGame($this->pdo, $data['search_game']);
            if (empty($games)) {
                header("Location: add_game");
            }
        } else {
            $games = getAllGames($this->pdo);
        }
        return $games;
    }

    public function showAddLibrary($games, $message) {
        $pdo = $this->pdo;
        require_once 'Views/addLibraryView.php';
    }
}
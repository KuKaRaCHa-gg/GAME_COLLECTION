<?php
// Inclure les dépendances nécessaires
require_once "./NavBar.php"; // Composant de navigation
require_once "./../Models/LibraryModel.php"; // Modèle pour les données de la bibliothèque
require_once "./../Views/LibraryView.php"; // Vue pour afficher la bibliothèque

class LibraryController {
    private $libraryModel;

    public function __construct() {
        // Initialiser le modèle de bibliothèque
        $this->libraryModel = new LibraryModel();
    }

    // Afficher la bibliothèque de jeux de l'utilisateur
    public function index() {
        session_start();

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header("Location: login_view.php");
            exit();
        }

        // Récupérer les jeux de l'utilisateur
        $games = $this->libraryModel->getGamesByUser($_SESSION['user_id']);

        // Charger la vue de la bibliothèque
        require_once "./../Views/LibraryView.php";
    }

    // Ajouter un jeu à la bibliothèque
    public function addGame() {
        session_start();

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header("Location: login_view.php");
            exit();
        }

        // Vérifier que le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gameData = [
                'user_id' => $_SESSION['user_id'],
                'game_name' => $_POST['game_name'],
                'editor' => $_POST['editor'],
                'release_date' => $_POST['release_date'],
                'cover_url' => $_POST['cover_url'],
                'hours_played' => 0 // Initialiser à 0 heure
            ];

            // Ajouter le jeu via le modèle
            $this->libraryModel->addGame($gameData);

            // Rediriger vers la bibliothèque
            header("Location: library.php");
            exit();
        }

        // Charger la vue d'ajout de jeu si la méthode n'est pas POST
        require_once "./../Views/add_game_view.php";
    }

    // Supprimer un jeu de la bibliothèque
    public function deleteGame($gameId) {
        session_start();

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header("Location: login_view.php");
            exit();
        }

        // Supprimer le jeu via le modèle
        $this->libraryModel->deleteGame($gameId);

        // Rediriger vers la bibliothèque
        header("Location: library.php");
        exit();
    }
}

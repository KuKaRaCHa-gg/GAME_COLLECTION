<?php

class HomeController {
    public function index() {
        session_start();
        
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header("Location: login_view.php");
            exit();
        }

        // Récupérer les données utilisateur et les jeux
        include_once 'models/User.php';
        include_once 'models/LibraryModel.php';
        $userModel = new User();
        $libraryModel = new LibraryModel();

        $user = $userModel->getUserById($_SESSION['user_id']);
        $games = $libraryModel->getGamesByUser($_SESSION['user_id']);

        // Charger la vue
        require_once 'views/home_view.php';
    }
}

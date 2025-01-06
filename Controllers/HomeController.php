<?php
require "./NavBar.php";
require "./../Models/User.php";
require "./../Models/LibraryModel.php";
require "./../Views/HomeView.php";

class HomeController {
    public function index() {
        session_start();

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header("Location: login_view.php");
            exit();
        }

        // Récupérer les données utilisateur et les jeux
        $userModel = new User();
        $libraryModel = new LibraryModel();
        
        $user = $userModel->getUserById($_SESSION['user_id']);
        $games = $libraryModel->getGamesByUser($_SESSION['user_id']);

        // Passer les données à la vue
        HomeView::render($user, $games);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Collection</title>
    <!-- Inclusion des fichiers CSS -->
    <link rel="stylesheet" type="text/css" href="Assets/CSS/General.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/NavBar.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/FormulaireConnexion.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Library.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Loading.css">
</head>
<body>

<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start(); // Démarrer la session
require_once 'Models/fonctionDB.php';
require_once 'Models/User.php';
$pdo = connexion();

// Autochargement des classes
spl_autoload_register(function ($class) {
    $paths = ['Controllers/', 'Models/'];
    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Sécuriser la variable d'action
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'login';

/*
// Rediriger les utilisateurs non connectés vers la page de connexion
$actions_non_securisees = ['login', 'register'];

if (!isset($_SESSION['user_id']) && !in_array($action, $actions_non_securisees)) {
    header("Location: index.php?action=login");
    exit();
}
*/

// Routage
switch ($action) {
    /*
    case 'login':
        require_once 'Views/login_view.php';
        break;
    */
    
    case 'register':
        require_once 'Views/register_view.php';
        break;

    case 'logout':
        /*
        session_destroy();
        header("Location: index.php?action=login");
        exit();
        */
        break;

    case 'add_game':
        // Suppression de la vérification de connexion
        $gameController = new GameController($pdo);
        $gameController->addGame();
        require_once 'Views/add_game_view.php';
        break;

    case 'ranking':
        // Suppression de la vérification de connexion
        $rankingController = new RankingController($pdo);
        $topPlayers = $rankingController->getTopPlayers();
        require_once 'Views/ranking_view.php';
        break;

    case 'library':
        // Suppression de la vérification de connexion
        require_once 'Views/LibraryView.php';
        break;

    case 'home':
        // Suppression de la vérification de connexion
        $gameController = new GameController($pdo);
        $userGames = $gameController->getUserGames($_SESSION['user_id'] ?? null);
        require_once 'Views/home_view.php';
        break;

    case 'profile':
        // Suppression de la vérification de connexion
        $authController = new AuthController($pdo);
        $userProfile = $authController->getUserProfile($_SESSION['user_id'] ?? null);
        require_once 'Views/profile_view.php';
        break;

    case 'loading':
        require_once 'Views/Loading.php';
        break;

    default:
        echo "<p>Page introuvable.</p>";
        break;
}
?>
</body>
</html>

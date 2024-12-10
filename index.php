<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(DIR, 'myconfig');
$dotenv->load();

echo "Fonctionne";
session_start(); // Démarrer la session
//require_once __DIR__ . './config/database.php'; // Connexion à la base de données
echo "Fonctionne";

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
echo "Fonctionne";

// Sécuriser la variable d'action
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'home';

// Vérifier si l'utilisateur est connecté pour les actions sécurisées
if (!isset($_SESSION['user_id']) && !in_array($action, ['login', 'register'])) {
    header("Location: index.php?action=login");
    exit();
}
echo "Fonctionne";

// Routage
switch ($action) {
    case 'login':
        require_once 'Views/login_view.php';
        break;

    case 'register':
        require_once 'Views/register_view.php';
        break;

    case 'logout':
        session_destroy();
        header("Location: index.php?action=login");
        exit();

    case 'add_game':
        $gameController = new GameController();
        $gameController->addGame();
        require_once 'Views/add_game_view.php';
        break;

    case 'ranking':
        $rankingController = new RankingController();
        $topPlayers = $rankingController->getTopPlayers();
        require_once 'Views/ranking_view.php';
        break;

    case 'profile':
        $authController = new AuthController();
        $userProfile = $authController->getUserProfile($_SESSION['user_id']);
        require_once 'Views/profile_view.php';
        break;

    case 'home':
    default:
        $gameController = new GameController();
        $userGames = $gameController->getUserGames($_SESSION['user_id']);
        require_once 'Views/home_view.php';
        break;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Collection</title>
    <!-- Inclusion des fichiers CSS -->
    <link rel="stylesheet" type="text/css" href="Assets/CSS/General.css">
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

// Liste des actions accessibles sans connexion
$actions_non_securisees = ['login', 'register'];

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) && !in_array($action, $actions_non_securisees)) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: index.php?action=login");
    exit();
}

// Routage
try {
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
            $gameController = new GameController($pdo);
            $gameController->addGame();
            require_once 'Views/add_game_view.php';
            break;

        case 'ranking':
            $rankingController = new RankingController($pdo);
            $topPlayers = $rankingController->getTopPlayers();
            require_once 'Views/ranking_view.php';
            break;

        case 'library':
            require_once 'Views/LibraryView.php';
            break;

        case 'home':
            $gameController = new GameController($pdo);
            $userGames = $gameController->getUserGames($_SESSION['user_id']);
            require_once 'Views/home_view.php';
            break;

        case 'profile':
            $authController = new AuthController($pdo);
            $userProfile = $authController->getUserProfile($_SESSION['user_id']);
            require_once 'Views/profile_view.php';
            break;

        default:
            echo "<p>Page introuvable.</p>";
            break;
    }
} catch (Exception $e) {
    // Gestion des erreurs
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
}
?>
</body>
</html>

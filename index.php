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
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Ranking.css">
</head>
<body>

<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start(); // Démarrer la session
require_once 'Models/fonctionDB.php';
require_once 'Models/User.php';

// Connexion à la base de données
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

// Déterminer l'action
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'home';

// Messages de débogage
echo "Action : $action<br>"; 
echo "Session User ID : " . ($_SESSION['user_id'] ?? 'Non défini') . "<br>";

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
            // Vérifier si GameController est chargé
            if (!class_exists('GameController')) {
                throw new Exception("GameController non défini");
            }
            $gameController = new GameController($pdo);
            $gameController->addGame();
            require_once 'Views/add_game_view.php';
            break;

        case 'ranking':
            /*if (!class_exists('RankingController')) {
                throw new Exception("RankingController non défini");
            }
            $rankingController = new RankingController($pdo);
            $topPlayers = $rankingController->getTopPlayers();*/
            require_once 'Views/ranking_view.php';
            break;

        case 'profile':
            require_once 'Views/profile_view.php';
            break;

        case 'home':
        default:
            require_once 'Views/home_view.php';
            break;
    }
} catch (Exception $e) {
    // Gestion des erreurs
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
}
?>
</body>
</html>

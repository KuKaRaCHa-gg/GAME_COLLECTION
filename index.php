<?php include 'Controllers/NavBar.php'; ?>

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
    
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Loading.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Ranking.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Profil.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/footer.css">
</head>
<body>

<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start(); // Démarrer la session
require_once 'Models/fonctionDB.php';
require_once 'Models/User.php';
require_once 'Models/Game.php';
require_once 'Models/LibraryModel.php';
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

$authController = new AuthController($pdo);

// Routage
try {
    switch ($action) {
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->login($_POST);
            } else {
                require_once 'Views/login_view.php';
            }
            break;

        case 'register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->register($_POST);
            } else {
                require_once 'Views/register_view.php';
            }
            break;

        case 'logout':
            $authController->logout();
            break;

            case 'add_game':
                $gameController = new GameController($pdo);
                $message = '';
                $messageType = 'info';
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $message = $gameController->addGame($_POST);
                    $messageType = str_contains($message, 'succès') ? 'success' : 'error';
                }
                require_once 'Views/add_game_view.php';
                break;
            
            

        case 'ranking':
            $ranlingController = new RankingController($pdo);
            $ranlingController->showRanking();
            require_once 'Views/ranking_view.php';
            break;

        case 'home':
            require_once 'Views/LibraryView.php';
            break;

        case 'add':
            $addLibraryController = new AddLibraryController($pdo);
            $games = $addLibraryController->searchGame($_POST);
            $message = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $message = $addLibraryController->addGame($_POST);
            }
            $addLibraryController->showAddLibrary($games);
            require_once 'Views/addLibraryView.php';
            break;

        case 'modifyGame':
            $game = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
            $ModifyGameController = new ModifyGameController($pdo);
            $ModifyGameController->showGame($game);
            require_once 'Views/modifyGameView.php';
            break;

        case 'profile':
            $authController->showProfile();
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

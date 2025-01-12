<?php include 'Controllers/NavBar.php'; ?> <!-- Inclusion de la barre de navigation -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Collection</title>
    <!-- Inclusion des fichiers CSS pour le design global -->
    <link rel="stylesheet" href="Assets/CSS/General.css">
    <link rel="stylesheet" href="Assets/CSS/NavBar.css">
    <link rel="stylesheet" href="Assets/CSS/FormulaireConnexion.css">
    <link rel="stylesheet" href="Assets/CSS/Loading.css">
    <link rel="stylesheet" href="Assets/CSS/Ranking.css">
    <link rel="stylesheet" href="Assets/CSS/Profil.css">
    <link rel="stylesheet" href="Assets/CSS/footer.css">
</head>
<body>

<?php
require 'vendor/autoload.php'; // Chargement automatique des dépendances (composer)

// Chargement des variables d'environnement (.env)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Démarrage de la session PHP
session_start();

// Connexion à la base de données
require_once 'Models/fonctionDB.php';
$pdo = connexion(); // Création de la connexion PDO

// Autochargement des classes (Modèles et Contrôleurs)
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

// Déterminer l'action à effectuer
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'login'; // Par défaut, redirige vers la page de connexion

// Liste des actions accessibles sans être connecté
$actions_non_securisees = ['login', 'register'];

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id']) && !in_array($action, $actions_non_securisees)) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: index.php?action=login");
    exit();
}

try {
    // Routage principal
    switch ($action) {
        case 'login':
            $authController = new AuthController($pdo); // Instanciation du contrôleur d'authentification
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->login($_POST); // Traitement des données envoyées par le formulaire de connexion
            } else {
                require_once 'Views/login_view.php'; // Chargement de la vue de connexion
            }
            break;

        case 'register':
            $authController = new AuthController($pdo); // Contrôleur d'authentification
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->register($_POST); // Inscription d'un nouvel utilisateur
            } else {
                require_once 'Views/register_view.php'; // Chargement de la vue d'inscription
            }
            break;

        case 'logout':
            $authController = new AuthController($pdo);
            $authController->logout(); // Déconnexion de l'utilisateur
            break;

        case 'add_game':
            $gameController = new GameController($pdo); // Contrôleur pour gérer les jeux
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $message = $gameController->addGame($_POST); // Ajout d'un jeu à la base de données
                $messageType = str_contains($message, 'succès') ? 'success' : 'error'; // Déterminer le type de message
            }
            require_once 'Views/add_game_view.php'; // Vue pour ajouter un jeu
            break;

        case 'ranking':
            $rankingController = new RankingController($pdo); // Contrôleur pour gérer le classement
            $rankingController->showRanking(); // Affichage du classement
            break;

        case 'home':
            $libraryController = new LibraryController($pdo); // Contrôleur pour gérer la bibliothèque
            $libraryController->showLibrary(); // Affichage des jeux de la bibliothèque
            require_once 'Views/LibraryView.php'; // Chargement de la vue correspondante
            break;

        case 'add':
            $addLibraryController = new AddLibraryController($pdo); // Contrôleur pour ajouter un jeu à la bibliothèque
            $games = $addLibraryController->searchGame($_POST ?? []); // Recherche de jeux si des données sont soumises
            $message = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $message = $addLibraryController->addGame($_POST); // Ajout d'un jeu spécifique
            }
            require_once 'Views/add_library_view.php'; // Vue d'ajout à la bibliothèque
            break;

        case 'modifyGame':
            $modifyGameController = new ModifyGameController($pdo); // Contrôleur pour modifier un jeu
            $gameId = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null; // Récupération de l'ID du jeu
            $modifyGameController->showGame($gameId); // Affichage des informations du jeu pour modification
            break;

        case 'profile':
            $authController = new AuthController($pdo); // Contrôleur d'authentification
            $authController->showProfile(); // Affichage du profil utilisateur
            break;

        default:
            // Affichage d'une erreur pour une action non reconnue
            echo "<p>Page introuvable. Veuillez vérifier l'URL.</p>";
            break;
    }
} catch (Exception $e) {
    // Gestion des erreurs globales
    echo "<p>Une erreur s'est produite : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
</body>
</html>

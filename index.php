<?php include 'Controllers/NavBar.php'; ?> <!-- Inclusion de la barre de navigation -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Collection</title>
    <!-- Inclusion des fichiers CSS -->
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
require 'vendor/autoload.php'; // Chargement des dépendances via Composer

// Chargement des variables d'environnement (depuis le fichier .env)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Démarrer une session PHP
session_start();

// Connexion à la base de données
require_once 'Models/fonctionDB.php';
$pdo = connexion(); // Crée une connexion PDO pour interagir avec la base

// Autoload pour les classes (Modèles et Contrôleurs)
spl_autoload_register(function ($class) {
    $paths = ['Controllers/', 'Models/']; // Répertoires à scanner
    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class . '.php'; // Construire le chemin
        if (file_exists($file)) {
            require_once $file; // Charger la classe si elle existe
            return;
        }
    }
});

// Récupérer l'action depuis l'URL (avec le paramètre raccourci "a")
$action = isset($_GET['a']) ? htmlspecialchars($_GET['a']) : 'login'; // Par défaut, afficher la page de connexion

// Actions accessibles sans connexion
$actions_non_securisees = ['login', 'register'];

// Vérifier si l'utilisateur est connecté pour accéder aux autres actions
if (!isset($_SESSION['user_id']) && !in_array($action, $actions_non_securisees)) {
    header("Location: /login"); // Rediriger vers la page de connexion
    exit();
}

try {
    // Routage principal basé sur l'action
    switch ($action) {
        case 'login':
            $authController = new AuthController($pdo); // Contrôleur pour l'authentification
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->login($_POST); // Traitement du formulaire de connexion
            } else {
                require_once 'Views/login_view.php'; // Affichage de la vue de connexion
            }
            break;

        case 'register':
            $authController = new AuthController($pdo); // Contrôleur pour l'inscription
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->register($_POST); // Traitement du formulaire d'inscription
            } else {
                require_once 'Views/register_view.php'; // Affichage de la vue d'inscription
            }
            break;

        case 'logout':
            $authController = new AuthController($pdo);
            $authController->logout(); // Déconnexion de l'utilisateur
            break;

        case 'add':
            $gameController = new GameController($pdo); // Contrôleur pour gérer les jeux
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $message = $gameController->addGame($_POST); // Ajouter un jeu
            }
            require_once 'Views/add_game_view.php'; // Vue pour ajouter un jeu
            break;

        case 'ranking':
            $rankingController = new RankingController($pdo); // Contrôleur pour afficher le classement
            $rankingController->showRanking(); // Afficher les joueurs classés
            break;

        case 'home':
            $libraryController = new LibraryController($pdo); // Contrôleur pour la bibliothèque
            $libraryController->showLibrary(); // Afficher la bibliothèque de jeux
            require_once 'Views/LibraryView.php'; // Vue pour la bibliothèque
            break;

        case 'profile':
            $authController = new AuthController($pdo); // Contrôleur pour le profil utilisateur
            $authController->showProfile(); // Afficher le profil
            break;

        default:
            echo "<p>Page introuvable. Veuillez vérifier l'URL.</p>"; // Message d'erreur pour les actions inconnues
            break;
    }
} catch (Exception $e) {
    // Gestion globale des erreurs
    echo "<p>Une erreur s'est produite : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
</body> 
</html>

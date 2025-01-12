<?php include 'Controllers/NavBar.php'; ?> <!-- Inclusion de la barre de navigation -->

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
require 'vendor/autoload.php'; // Chargement des dépendances via Composer

// Charger les variables d'environnement depuis le fichier .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start(); // Démarrer la session utilisateur

// Connexion à la base de données
require_once 'Models/fonctionDB.php';
require_once 'Models/User.php';
require_once 'Models/Game.php';
require_once 'Models/LibraryModel.php';
$pdo = connexion(); // Connexion PDO à la base

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

// Récupérer l'action via l'URL simplifiée
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'home'; // Par défaut, aller sur la page d'accueil

// Liste des actions accessibles sans connexion utilisateur
$actions_non_securisees = ['login', 'register'];

// Vérifier si l'utilisateur est connecté pour accéder aux autres pages
if (!isset($_SESSION['user_id']) && !in_array($action, $actions_non_securisees)) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
    header("Location: /login");
    exit();
}

$authController = new AuthController($pdo); // Instancier le contrôleur d'authentification

// Routage des actions
try {
    switch ($action) {
        case 'login': // Page de connexion
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->login($_POST); // Traiter les données du formulaire de connexion
            } else {
                require_once 'Views/login_view.php'; // Afficher la vue de connexion
            }
            break;

        case 'register': // Page d'inscription
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->register($_POST); // Traiter les données du formulaire d'inscription
            } else {
                require_once 'Views/register_view.php'; // Afficher la vue d'inscription
            }
            break;

        case 'logout': // Déconnexion
            $authController->logout(); // Détruire la session utilisateur
            break;

        case 'add_game': // Ajouter un jeu
            $gameController = new GameController($pdo);
            $message = '';
            $messageType = 'info';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $message = $gameController->addGame($_POST); // Ajouter un jeu
                $messageType = str_contains($message, 'succès') ? 'success' : 'error';
            }
            require_once 'Views/add_game_view.php'; // Afficher la vue pour ajouter un jeu
            break;

        case 'ranking': // Page de classement
            $rankingController = new RankingController($pdo); // Instancier le contrôleur du classement
            $rankingController->showRanking(); // Afficher les joueurs classés
            break;

        case 'home': // Page d'accueil ou bibliothèque
            $libraryController = new LibraryController($pdo); // Instancier le contrôleur de bibliothèque
            $libraryController->showLibrary(); // Afficher la bibliothèque de jeux
            require_once 'Views/LibraryView.php'; // Charger la vue de bibliothèque
            break;

        case 'add': // Ajouter un jeu à la bibliothèque
            $addLibraryController = new AddLibraryController($pdo);
            $games = $addLibraryController->searchGame($_POST); // Rechercher des jeux
            $message = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $message = $addLibraryController->addGame($_POST); // Ajouter un jeu à la bibliothèque
            }
            $addLibraryController->showAddLibrary($games, $message); // Afficher les résultats de recherche
            break;

        case 'modifyGame': // Modifier un jeu existant
            $game = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : ''; // Récupérer l'identifiant du jeu
            $modifyGameController = new ModifyGameController($pdo); // Instancier le contrôleur de modification
            $modifyGameController->showGame($game); // Afficher les détails du jeu à modifier
            break;

        case 'profile': // Profil utilisateur
            $authController->showProfile(); // Afficher les informations du profil utilisateur
            break;

        default: // Action inconnue
            echo "<p>Page introuvable. Veuillez vérifier l'URL.</p>"; // Afficher un message d'erreur pour les actions non reconnues
            break;
    }
} catch (Exception $e) {
    // Gestion globale des erreurs
    echo "<p>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
</body>
</html>

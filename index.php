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

// Charger les variables d'environnement depuis le fichier .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Démarrer une session PHP pour gérer l'état utilisateur
session_start();

// Connexion à la base de données
require_once 'Models/fonctionDB.php'; // Fichier contenant la fonction de connexion PDO
require_once 'Models/User.php'; // Modèle utilisateur
require_once 'Models/Game.php'; // Modèle jeu
require_once 'Models/LibraryModel.php'; // Modèle bibliothèque
$pdo = connexion(); // Créer une connexion PDO pour interagir avec la base

// Autochargement des classes pour éviter d'inclure manuellement chaque fichier
spl_autoload_register(function ($class) {
    $paths = ['Controllers/', 'Models/']; // Répertoires à scanner
    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class . '.php'; // Construire le chemin vers la classe
        if (file_exists($file)) {
            require_once $file; // Charger la classe si elle existe
            return;
        }
    }
});

// Sécuriser la récupération de l'action via l'URL
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'login'; // Par défaut, afficher la page de connexion

// Définir les actions accessibles sans authentification
$actions_non_securisees = ['login', 'register'];

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) && !in_array($action, $actions_non_securisees)) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: index.php?action=login");
    exit();
}

// Instancier le contrôleur d'authentification pour les actions liées à l'utilisateur
$authController = new AuthController($pdo);

try {
    // Routage basé sur l'action demandée dans l'URL
    switch ($action) {
        case 'login': // Page de connexion
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->login($_POST); // Traite les données du formulaire de connexion
            } else {
                require_once 'Views/login_view.php'; // Affiche la vue de connexion
            }
            break;

        case 'register': // Page d'inscription
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->register($_POST); // Traite les données du formulaire d'inscription
            } else {
                require_once 'Views/register_view.php'; // Affiche la vue d'inscription
            }
            break;

        case 'logout': // Déconnexion
            $authController->logout(); // Détruit la session de l'utilisateur
            break;

        case 'add_game': // Ajouter un jeu
            $gameController = new GameController($pdo); // Contrôleur pour gérer les jeux
            $message = ''; // Message vide par défaut
            $messageType = 'info'; // Type de message (success, error, info)
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $message = $gameController->addGame($_POST); // Appelle la méthode pour ajouter un jeu
                $messageType = str_contains($message, 'succès') ? 'success' : 'error'; // Détecte si l'ajout a réussi
            }
            require_once 'Views/add_game_view.php'; // Charge la vue pour ajouter un jeu
            break;

        case 'ranking': // Page de classement
            $rankingController = new RankingController($pdo); // Contrôleur pour gérer le classement
            $rankingController->showRanking(); // Affiche les joueurs classés
            break;

        case 'home': // Page d'accueil (bibliothèque de jeux)
            $libraryController = new LibraryController($pdo); // Contrôleur pour gérer la bibliothèque
            $libraryController->showLibrary(); // Affiche les jeux de la bibliothèque
            require_once 'Views/LibraryView.php'; // Charge la vue pour afficher la bibliothèque
            break;

        case 'add': // Ajouter un jeu à la bibliothèque
            $addLibraryController = new AddLibraryController($pdo); // Contrôleur pour l'ajout dans la bibliothèque
            $games = $addLibraryController->searchGame($_POST); // Recherche des jeux dans la base
            $message = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $message = $addLibraryController->addGame($_POST); // Ajoute un jeu à la bibliothèque
            }
            $addLibraryController->showAddLibrary($games, $message); // Affiche la vue avec les résultats et le message
            break;

        case 'modifyGame': // Modifier un jeu existant
            $game = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : ''; // Récupère le type de jeu à modifier
            $modifyGameController = new ModifyGameController($pdo); // Contrôleur pour gérer les modifications
            $modifyGameController->showGame($game); // Affiche les détails du jeu à modifier
            break;

        case 'profile': // Profil utilisateur
            $authController->showProfile(); // Affiche les informations du profil utilisateur
            break;

        default: // Action inconnue
            echo "<p>Page introuvable. Veuillez vérifier l'URL.</p>"; // Affiche une erreur si l'action est invalide
            break;
    }
} catch (Exception $e) {
    // Gérer les erreurs globales
    echo "<p>Une erreur s'est produite : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
</body>
</html>

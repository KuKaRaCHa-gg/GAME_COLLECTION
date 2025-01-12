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
require_once 'Models/fonctionDB.php'; // Fonction pour établir la connexion PDO
require_once 'Models/User.php'; // Modèle utilisateur
require_once 'Models/Game.php'; // Modèle jeu
require_once 'Models/LibraryModel.php'; // Modèle bibliothèque
$pdo = connexion(); // Créer une connexion PDO

// Autochargement des classes pour éviter les multiples inclusions manuelles
spl_autoload_register(function ($class) {
    $paths = ['Controllers/', 'Models/']; // Répertoires contenant les classes
    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class . '.php'; // Construire le chemin du fichier
        if (file_exists($file)) {
            require_once $file; // Charger le fichier si trouvé
            return;
        }
    }
});

// Sécuriser la récupération du paramètre "action" dans l'URL
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'login'; // Par défaut, afficher la page de connexion

// Liste des actions accessibles sans authentification
$actions_non_securisees = ['login', 'register'];

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) && !in_array($action, $actions_non_securisees)) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
    header("Location: index.php?action=login");
    exit();
}

// Instancier le contrôleur d'authentification
$authController = new AuthController($pdo);

try {
    // Routage principal en fonction de l'action demandée
    switch ($action) {
        case 'login': // Page de connexion
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->login($_POST); // Traitement du formulaire de connexion
            } else {
                require_once 'Views/login_view.php'; // Chargement de la vue de connexion
            }
            break;

        case 'register': // Page d'inscription
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->register($_POST); // Traitement du formulaire d'inscription
            } else {
                require_once 'Views/register_view.php'; // Chargement de la vue d'inscription
            }
            break;

        case 'logout': // Déconnexion
            $authController->logout(); // Détruire la session utilisateur
            break;

        case 'add_game': // Ajouter un jeu
            $gameController = new GameController($pdo); // Contrôleur pour les jeux
            $message = '';
            $messageType = 'info'; // Message informatif par défaut
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $message = $gameController->addGame($_POST); // Ajout d'un jeu à la base
                $messageType = str_contains($message, 'succès') ? 'success' : 'error'; // Déterminer le type de message
            }
            require_once 'Views/add_game_view.php'; // Vue pour ajouter un jeu
            break;

        case 'ranking': // Page de classement
            $rankingController = new RankingController($pdo); // Contrôleur pour le classement
            $rankingController->showRanking(); // Affichage des joueurs classés
            break;

        case 'home': // Page d'accueil/bibliothèque
            $libraryController = new LibraryController($pdo); // Contrôleur pour la bibliothèque
            $libraryController->showLibrary(); // Affichage des jeux de la bibliothèque
            require_once 'Views/LibraryView.php'; // Vue bibliothèque
            break;

        case 'add': // Ajouter un jeu à la bibliothèque
            $addLibraryController = new AddLibraryController($pdo); // Contrôleur pour gérer l'ajout
            $games = $addLibraryController->searchGame($_POST); // Rechercher des jeux
            $message = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $message = $addLibraryController->addGame($_POST); // Ajout d'un jeu à la bibliothèque
            }
            $addLibraryController->showAddLibrary($games, $message); // Afficher les résultats de recherche et le message
            break;

        case 'modifyGame': // Modifier un jeu existant
            $game = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : ''; // Récupérer le type de jeu
            $modifyGameController = new ModifyGameController($pdo); // Contrôleur pour la modification
            $modifyGameController->showGame($game); // Afficher les détails du jeu à modifier
            break;

        case 'profile': // Profil utilisateur
            $authController->showProfile(); // Afficher le profil utilisateur
            break;

        default: // Action inconnue
            echo "<p>Page introuvable. Veuillez vérifier l'URL.</p>"; // Message d'erreur
            break;
    }
} catch (Exception $e) {
    // Gestion globale des erreurs
    echo "<p>Une erreur s'est produite : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
</body>
</html>

<?php include 'header.php'; 
require_once 'Models/fonctionDB.php';
require_once 'Models/User.php';
require_once 'Models/UserGame.php';
require_once 'Models/LibraryModel.php';
$pdo = connexion(); ?>
<div class="home-container">
    <h1>Salut <?= htmlspecialchars(getPrenom($pdo, $_SESSION['user_id']) ?? 'Utilisateur'); ?> ! Prêt à ajouter des jeux à ta collection ?</h1>
    <div class="game-list">
        <?php afficherJeu($pdo, $_SESSION['user_id']); ?>
    </div>
</div>
<?php include 'footer.php'; ?>

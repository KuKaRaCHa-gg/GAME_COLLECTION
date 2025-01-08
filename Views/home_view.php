<?php include 'header.php'; 
require_once 'Models/fonctionDB.php';
require_once 'Models/User.php';
require_once 'Models/UserGame.php';
require_once 'Models/LibraryModel.php';
$pdo = connexion(); ?>
<div class="home-container">
    <h1>Salut <?= htmlspecialchars(getPrenom($pdo, $_SESSION['user_id']) ?? 'Utilisateur'); ?> ! Prêt à ajouter des jeux à ta collection ?</h1>
    <div class="game-list">
        <?php $userGames = getUserGame($pdo, $_SESSION['user_id']); 
        foreach ($userGames as $game): ?>
            <div class="game-card">
                <img src="<?= htmlspecialchars($game['url_cover_game']); ?>" alt="Couverture du jeu">
                <h2><?= htmlspecialchars($game['nom_game']); ?></h2>
                <p>Éditeur : <?= htmlspecialchars($game['edit_game']); ?></p>
                <p>Heures jouées : <?= htmlspecialchars($game['time_game']); ?>h</p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footer.php'; ?>

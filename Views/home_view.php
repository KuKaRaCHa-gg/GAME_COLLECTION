<?php include 'header.php'; 
require_once 'Models/fonctionDB.php';
require_once 'Models/User.php';
$pdo = connexion(); ?>
<div class="home-container">
    <h1>Salut <?= htmlspecialchars(getPrenom($pdo, $_SESSION['user_id']) ?? 'Utilisateur'); ?> ! Prêt à ajouter des jeux à ta collection ?</h1>
    <div class="game-list">
        <?php foreach ($userGames as $game): ?>
            <div class="game-card">
                <img src="<?= htmlspecialchars($game['cover_url']); ?>" alt="Couverture du jeu">
                <h2><?= htmlspecialchars($game['name']); ?></h2>
                <p>Éditeur : <?= htmlspecialchars($game['publisher']); ?></p>
                <p>Heures jouées : <?= htmlspecialchars($game['hours_played']); ?>h</p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footer.php'; ?>

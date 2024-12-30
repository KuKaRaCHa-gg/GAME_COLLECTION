<?php include 'header.php'; ?>
<div class="ranking-container">
    <h1>Classement des Joueurs</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Heures jouées</th>
                <th>Jeu favori</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($topPlayers as $player): ?>
                <tr>
                    <td><?= htmlspecialchars($player['name']); ?></td>
                    <td><?= htmlspecialchars($player['hours_played']); ?>h</td>
                    <td><?= htmlspecialchars($player['favorite_game']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>

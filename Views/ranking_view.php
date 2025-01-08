<?php
require_once 'Models/UserGame.php';
require_once 'Models/fonctionDB.php';
$pdo = connexion(); ?>
<div class="table-container">
</br>
    </br>
    </br>
    <div>
<h2 class="RankingTitre">Classement des temps passés</h2>

    <table style ='width: 80%;'>
        <thead>
            <tr>
                <th>Joueur</th>
                <th>Temps passés</th>
                <th>Jeu favori</th>
            </tr>
        </thead>
        <tbody>
            <?php getTopRanking($pdo)?>
        </tbody>
    </table>

</div>
<?php include 'footer.php'; ?>

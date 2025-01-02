<?php include 'header.php'; 
require_once 'Models/UserGame.php';
require_once 'Models/fonctionDB.php';
$pdo = connexion(); ?>
<div class="ranking-container">
</br>
    </br>
    </br>
<h2>Classement des temps passés</h2>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Heures jouées</th>
                <th>Jeu favori</th>
            </tr>
        </thead>
        <tbody>
            <?php getTopRanking($pdo)?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>

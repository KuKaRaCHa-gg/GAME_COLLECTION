<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="table-container">
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
    
</body>
</html>
<?php include 'footer.php'; ?>

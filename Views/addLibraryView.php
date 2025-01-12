<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="Assets/CSS/games.css">
</head>
<body>

<div class="contentContainer">
<div class="toLeft">
<h1 class="page-title">Ajouter un jeu à sa bibliothèque</h1>
<br>
<form action="" method="POST" class="formDefaut">
        <div class="form-group">
            <input type="text" id="search_game" name="search_game" placeholder="Rechercher un jeu" class="inputRecherche">
        </div>
        <button type="submit" name="search_action" value="search_game" class="boutonRecherche">Rechercher</button>
    </form>


<h2 class="resultatAffiche"> Resultats de la recherche </h2>
<p><?php echo htmlspecialchars($message); ?></p>

<div class="gamesStorage">
<?php
foreach ($games as $game) {
    ?>
    <div class="game">
    <h3 class="gameTitle"> <?php echo $game['nom_game'] ?> </h3>
    <p class="gamePlatform"> <?php echo $game['type_plateforme'] ?></p>
    <img src= <?php echo htmlspecialchars($game['url_cover_game']) ?> alt="jeu" class="gameImage"/>
    <form action="" method="POST" class="formDefaut">
    <input type="hidden" name="id_game" value=" <?php echo $game['id_game'] ?> ">
    <input type="hidden" name="nom_game" value=" <?php echo $game['nom_game'] ?> ">
    <button type="submit" name="add_game" value="add_game" class="boutonAjout">AJOUTER A LA BIBLIOTHÈQUE</button>
    </form>
    </div>
    <?php

}
?>

<div class="plusBasFooter">
<?php include 'footer.php'; ?>
</div>
</div>
</div>
</div>

</body>
</html>

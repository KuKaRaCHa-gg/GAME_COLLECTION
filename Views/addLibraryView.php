<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="contentContainer">
<div class="toLeft">
<h1 class="page-title">Ajouter un jeu à sa bibliothèque</h1>
<br>
<form action="" method="POST" class="formDefaut">
        <div class="form-group">
            <input type="text" id="search_game" name="search_game" placeholder="Rechercher un jeu">
        </div>
        <button type="submit" name="search_action" value="search_game">Rechercher</button>
    </form>


<h2> Resultats de la recherche </h2>
<?php 
$games = getAllGames($pdo);
foreach ($games as $game) {
    ?>
    <div class="game">
    <h3> <?php echo $game['nom_game'] ?> </h3>
    <p> <?php echo $game['type_plateforme'] ?></p>
    <img src= <?php echo htmlspecialchars($game['url_cover_game']) ?> alt="jeu" class="gameImage"/>';
    <form action="" method="POST" class="formDefaut">
    <input type="hidden" name="id_game" value=" <?php echo $game['id_game'] ?> ">
    <button type="submit" name="add_game" value="add_game">Ajouter</button>
    </form>
    </div>
    <?php
}
if (isset($_POST['add_game'])) {
    if (verifyGame($pdo, $_SESSION['user_id'], $_POST['id_game']) == true) {
        echo 'Le jeu est déjà dans votre bibliothèque';
    } else {
        addGameToLibrary($pdo, $_SESSION['user_id'], $_POST['id_game']);
        echo 'Le jeu a bien été ajouté à votre bibliothèque';
    }
}


?>
</div>
</div>
</body>
</html>
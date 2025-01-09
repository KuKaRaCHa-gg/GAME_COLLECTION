<?php
?>
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
            <input type="text" id="search_game" name="search_game" placeholder="Rechercher un jeu">
        </div>
        <button type="submit" name="search_action" value="search_game">Rechercher</button>
    </form>


<h2 class="resultatAffiche"> Resultats de la recherche </h2>
<?php 
if (isset($_POST['add_game'])) {
    if (verifyGame($pdo, $_SESSION['user_id'], $_POST['id_game']) == true) {
        ?>
        <p class="messageAjout">Le jeu <?php echo htmlspecialchars($_POST['nom_game']) ?> est déjà dans votre bibliothèque </p>
        <?php 
    } else {
        addGameToLibrary($pdo, $_SESSION['user_id'], $_POST['id_game']);
        ?>
        <p class="messageAjout">Le jeu <?php echo htmlspecialchars($_POST['nom_game']) ?> a bien été ajouté à votre bibliothèque </p>
        <?php 
    }
}
?>
</div>
</div>
<?php 
if (isset($_POST['search_action']) && $_POST['search_game'] != '') {
    $games = searchGame($pdo, $_POST['search_game']);
    if (empty($games)) {
        header("Location: index.php?action=add_game");
    }
} else {
    $games = getAllGames($pdo);
}
?>
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

</body>
</html>

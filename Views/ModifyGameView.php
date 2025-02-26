<!DOCTYPE>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Modify.css">
</head>
<body>
    <div class="contentContainer">
    <div class="toLeft">
    <div id="boutons">
        <h2><?php echo htmlspecialchars($game['nom_game'])?></h2>
        <p><?php echo htmlspecialchars($game['desc_game'])?></p>
        <p>Temps passé : <?php echo htmlspecialchars($game['time_game'])?> h</p>
        <h2>Ajouter du temps passé sur le jeu</h2>
        <form action="modifyGame&type=<?php echo htmlspecialchars($game['id_library']) ?>" method="post" class="formDefaut">
            <label>Temps passé sur le jeu</label>
            <input type="number" name="time" placeholder="Temps passé" value="<?php echo htmlspecialchars($game['time_game']) ?>">
            <br>
            <input type="submit" value="AJOUTER" name="addTime">
        </form>
        <form action="modifyGame&type=<?php echo htmlspecialchars($game['id_library']) ?>" method="post" class="formDefaut">
            <input type="submit" value="SUPPRIMER LE JEU DE MA BIBLIOTHÈQUE" name="delete" class="supprimer">
        </form>
    </div>
        <img src= <?php echo htmlspecialchars($game['url_cover_game']) ?> alt="Logo" id="thumbnail">
    </div>
    <div class="plusBasFooter">
    <?php include 'footer.php'; ?>
    </div>
    </div>
</body>
</html>


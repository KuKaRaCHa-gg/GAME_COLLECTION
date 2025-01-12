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
        <form action="index.php?action=modifyGame&type=<?php echo htmlspecialchars($game['id_library']) ?>" method="post" class="formDefaut">
            <label>Temps passé sur le jeu</label>
            <input type="number" name="time" placeholder="Temps passé" value="<?php echo htmlspecialchars($game['time_game']) ?>" >
            <input type="submit" value="AJOUTER">
        </form>
        <button>
            SUPPRIMER LE JEU DE MA BIBLIOTHÈQUE
        </button>
    </div>
        <img src= <?php echo htmlspecialchars($game['url_cover_game']) ?> alt="Logo" id="thumbnail">
    </div>
    <div class="plusBasFooter">
    <?php include 'footer.php'; ?>
    </div>
    </div>
</body>
</html>


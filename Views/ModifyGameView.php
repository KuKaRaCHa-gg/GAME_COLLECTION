<!DOCTYPE>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Modify.css">
</head>
<body>
    <div id="boutons">
        <h3>Nom <?php echo htmlspecialchars($game['nom_game'])?></h3>
        <p>Description <?php echo htmlspecialchars($game['desc_game'])?></p>
        <p>Temps passé : <?php echo htmlspecialchars($game['time_game'])?></p>
        <h3>Ajouter du temps passé sur le jeu</h3>
        <form action="index.php?action=modifyGame" method="post">
            <input type="number" name="time" placeholder="Temps passé">
            <input type="submit" value="Ajouter">
        </form>
        <button>
            Supprimer le jeu
        </button>
    </div>
    <div id="thumbnail">
        <img src= <?php echo htmlspecialchars($game['url_cover_game']) ?> alt="Logo" style="width: 100px; height: 100px;">
    </div>
</body>
</html>
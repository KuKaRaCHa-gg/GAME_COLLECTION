<!DOCTYPE>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Modify.css">
</head>
<body>
    <div id="boutons">
        <h3>Nom</h3>
        <p>Description</p>
        <p>Temps passé : 100H</p>
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
        <img src="Assets/Images/Logo.png" alt="Logo" style="width: 100px; height: 100px;">
    </div>
</body>
</html>
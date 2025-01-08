<!DOCTYPE>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="./../Assets/CSS/General.css">
    <link rel="stylesheet" type="text/css" href="./../Assets/CSS/Library.css">
</head>
<body>
    <img src="./../Assets/Images/Font.png" alt="fond" id="hero">
    <h1>
        SALUT <?= htmlspecialchars(getPrenom($pdo, $_SESSION['user_id']) ?? 'Utilisateur'); ?> !
        <br>
        PRÊT À AJOUTER
        <br>
        JEUX À TA COLLECTION ?
    </h1>
    <h3>
        Mes jeux
    </h3>
    <div id = "gamesStorage">
        <?php
        afficherJeu($pdo, $_SESSION['user_id']);
        ?>
    </div>
</body>
</html>
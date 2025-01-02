<?php include 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="Assets/CSS/General.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/NavBar.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/FormulaireConnexion.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Library.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Loading.css">
<div class="add-game-container">
    <h1>Ajouter un jeu à sa bibliothèque</h1>
    <p>Vérifiez si le jeu que vous souhaitez ajouter existe déjà dans la base de données. Sinon, ajoutez-le !</p>

    <form action="index.php?action=add_game" method="POST">
        <label for="search_game">Rechercher un jeu :</label>
        <input type="text" id="search_game" name="search_game" placeholder="Nom du jeu">
        <button type="submit" name="action" value="search_game">Rechercher</button>
    </form>

    <hr>

    <h2>Ajouter un nouveau jeu</h2>
    <form action="index.php?action=add_game" method="POST">
        <label for="nom_game">Nom du jeu :</label>
        <input type="text" id="nom_game" name="nom_game" placeholder="Nom du jeu" required>

        <label for="edit_game">Éditeur du jeu :</label>
        <input type="text" id="edit_game" name="edit_game" placeholder="Éditeur du jeu" required>

        <label for="release_game">Sortie du jeu :</label>
        <input type="date" id="release_game" name="release_game" required>

        <label>Plateformes :</label>
        <div>
            <input type="checkbox" id="playstation" name="plateformes[]" value="Playstation">
            <label for="playstation">Playstation</label>

            <input type="checkbox" id="xbox" name="plateformes[]" value="Xbox">
            <label for="xbox">Xbox</label>

            <input type="checkbox" id="nintendo" name="plateformes[]" value="Nintendo">
            <label for="nintendo">Nintendo</label>

            <input type="checkbox" id="pc" name="plateformes[]" value="PC">
            <label for="pc">PC</label>
        </div>

        <label for="url_cover_game">URL de la cover :</label>
        <input type="url" id="url_cover_game" name="url_cover_game" placeholder="URL de la cover" required>

        <label for="url_site_game">URL du site :</label>
        <input type="url" id="url_site_game" name="url_site_game" placeholder="URL du site" required>

        <button type="submit">Ajouter le jeu</button>
    </form>
</div>
<?php include 'footer.php'; ?>

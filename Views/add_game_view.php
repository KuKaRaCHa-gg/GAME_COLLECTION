<head>
    <title>Ajouter un jeu à sa bibliothèque</title>
    <link rel="stylesheet" type="text/css" href="Assets/CSS/General.css">
    <!--<link rel="stylesheet" type="text/css" href="Assets/CSS/NavBar.css">-->
    <link rel="stylesheet" type="text/css" href="Assets/CSS/FormulaireConnexion.css">
</head>

<!-- Affichage des messages -->
<?php if (!empty($message)) : ?>
<div class="message-container <?php echo $messageType ?? 'info'; ?>">
    <strong>
        <?php 
            if ($messageType === 'success') {
                echo "Succès :";
            } elseif ($messageType === 'error') {
                echo "Erreur :";
            } else {
                echo "Information :";
            }
        ?>
    </strong>
    <p><?php echo htmlspecialchars($message); ?></p>
</div>
<?php endif; ?>

<div class="container">
    <div class="toLeft">
    <h1 class="page-title">Ajouter un jeu à sa bibliothèque</h1>
    <?php 
    /*
    <p class="page-description">Recherchez un jeu existant ou ajoutez-en un nouveau pour enrichir votre collection.</p>

    <!-- Formulaire de recherche -->
    <form action="index.php?action=add_game" method="POST" class="form-search">
        <div class="form-group">
            <label for="search_game">Rechercher un jeu :</label>
            <input type="text" id="search_game" name="search_game" placeholder="Entrez le nom du jeu">
        </div>
        <button type="submit" name="search_action" value="search_game" class="btn">Rechercher</button>
    </form>
    

    <hr>

    */?>

    <!-- Formulaire d'ajout -->
    <h3 class="section-title"> Le jeu que vous souhaiter ajouter n'existe pas ! Vous pouvez le créer, celui ci sera automatiquement ajouter a votre bibliothèque</h3>
    <form action="index.php?action=add_game" method="POST" class="formDefaut">
        <div class="form-group">
            <label for="nom_game">Nom du jeu :</label>
            <input type="text" id="nom_game" name="nom_game" placeholder="Nom du jeu" required>
        </div>

        <div class="form-group">
            <label for="edit_game">Éditeur du jeu :</label>
            <input type="text" id="edit_game" name="edit_game" placeholder="Éditeur du jeu" required>
        </div>

        <div class="form-group">
            <label for="release_game">Date de sortie :</label>
            <input type="date" id="release_game" name="release_game" required>
        </div>

        <div class="form-group">
            <label>Plateformes :</label>
            <div class="checkbox-group">
                <input type="checkbox" id="playstation" name="plateformes[]" value="Playstation">
                <label for="playstation">Playstation</label>

                <input type="checkbox" id="xbox" name="plateformes[]" value="Xbox">
                <label for="xbox">Xbox</label>

                <input type="checkbox" id="nintendo" name="plateformes[]" value="Nintendo">
                <label for="nintendo">Nintendo</label>

                <input type="checkbox" id="pc" name="plateformes[]" value="PC">
                <label for="pc">PC</label>
            </div>
        </div>

        <div class="form-group">
            <label for="desc_game">Description :</label>
            <textarea id="desc_game" name="desc_game" placeholder="Ajoutez une description du jeu (facultatif)" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label for="url_cover_game">URL de la couverture :</label>
            <input type="url" id="url_cover_game" name="url_cover_game" placeholder="Lien vers l'image de la couverture" required>
        </div>

        <div class="form-group">
            <label for="url_site_game">URL du site officiel :</label>
            <input type="url" id="url_site_game" name="url_site_game" placeholder="Lien vers le site officiel" required>
        </div>

        <button type="submit" name="add_action" value="add_game" class="btn">Ajouter le jeu</button>
    </form>
</div>
</div>

<?php include 'footer.php'; ?>

<?php include 'header.php'; ?>
<div class="add-game-container">
    <h1>Ajouter un jeu à sa bibliothèque</h1>
    <form action="index.php?action=add_game" method="POST">
        <label for="game_name">Nom du jeu :</label>
        <input type="text" id="game_name" name="game_name" required>

        <label for="publisher">Éditeur :</label>
        <input type="text" id="publisher" name="publisher" required>

        <label for="release_date">Date de sortie :</label>
        <input type="date" id="release_date" name="release_date" required>

        <label for="cover_url">URL de la couverture :</label>
        <input type="url" id="cover_url" name="cover_url" required>

        <label for="hours_played">Temps joué (heures) :</label>
        <input type="number" id="hours_played" name="hours_played" min="0" required>

        <button type="submit">Ajouter à la bibliothèque</button>
    </form>
</div>
<?php include 'footer.php'; ?>

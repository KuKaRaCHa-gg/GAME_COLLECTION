<?php




function afficherJeu($pdo, $id)
{
    $query = $pdo->prepare("SELECT * FROM GAME INNER JOIN LIBRARY ON GAME.id_game = LIBRARY.id_game WHERE LIBRARY.id_user = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($result as $game)
    {
        echo '<div class = "game">';
        echo '<img src=' . htmlspecialchars($game['url_cover_game']) . 'alt="jeu" class="gameImage"/>'; //Image du jeu
        echo '<h2 class="gameTitle">';
        echo htmlspecialchars($game['nom_game']); //Nom du jeu
        echo '</h2>';
        echo '<p class="gameHours">';
        echo htmlspecialchars($game['time_game']) . 'H'; //Nombre d'heures jouées au jeu
        echo '</p>';
        echo '<p class="gamePlatform">';
        echo htmlspecialchars($game['type_plateforme']);//Plateforme du jeu
        echo ' </p>';
        echo '<a class="details">'; //Il faut ajouter un lien à la page du jeu en particulier
        echo '<a href="Controllers/ModifyGameController.php"> VOIR LE JEU</a>'; //Texte affiché lors du surlignage qui servira à accéder aux détails du jeu
        echo '</a>';
        echo '</div>';
    }
}

<?php

/* WHERE (LIBRARY.id_user, time_game) IN (SELECT LIBRARY.id_user, MAX(time_game) FROM LIBRARY GROUP BY LIBRARY.id_user) */

function getTopRanking($pdo)
{
    $query = $pdo->prepare("SELECT nom_user, pren_user, time_game, nom_game FROM GAME INNER JOIN LIBRARY ON GAME.id_game = LIBRARY.id_game INNER JOIN UTILISATEUR ON LIBRARY.id_user = UTILISATEUR.id_user
 ORDER BY time_game DESC LIMIT 20");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row['nom_user'] . " " . $row['pren_user'] . "</td>";
        echo "<td>" . $row['time_game'] . " h" ."</td>";
        echo "<td>" . $row['nom_game'] . "</td>";
        echo "</tr>";
    }
}



function getUserGame($pdo, $id)
{
    $query = $pdo->prepare("SELECT * FROM GAME INNER JOIN LIBRARY ON GAME.id_game = LIBRARY.id_game WHERE LIBRARY.id_user = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        echo "<div class='game-card'>";
        if (!empty($row['url_cover_game'])) {
            echo '<img src="' . htmlspecialchars($row['url_cover_game']) . '" alt="Cover du jeu" width="15%" height="15%">';
        }
        echo "<h2>" . $row['nom_game'] . "</h2>";
        echo "<p>Éditeur : " . $row['edit_game'] . "</p>";
        echo "<p>Heures jouées : " . $row['time_game'] . "h</p>";
        echo "</div>";
    }
}
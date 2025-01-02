<?php

function getTopRanking($pdo)
{
    $query = $pdo->prepare("SELECT nom_user, pren_user, time_game, nom_game FROM GAME INNER JOIN LIBRARY ON GAME.id_game = LIBRARY.id_game INNER JOIN UTILISATEUR ON LIBRARY.id_user = UTILISATEUR.id_user
     ORDER BY time_game ASC");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row['nom_user'] . " " . $row['pren_user'] . "</td>";
        echo "<td>" . $row['time_game'] . "</td>";
        echo "<td>" . $row['nom_game'] . "</td>";
        echo "</tr>";
    }
}
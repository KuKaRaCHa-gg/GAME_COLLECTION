<?php
class UserGame {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Ajouter un jeu pour un utilisateur
    public function addGame($userId, $gameId, $hoursPlayed = 0) {
        $stmt = $this->pdo->prepare("INSERT INTO user_games (user_id, game_id, hours_played) 
                                     VALUES (:user_id, :game_id, :hours_played)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':game_id', $gameId);
        $stmt->bindParam(':hours_played', $hoursPlayed);
        return $stmt->execute();
    }

    // Mettre à jour le temps joué
    public function updateHours($userGameId, $hoursPlayed) {
        $stmt = $this->pdo->prepare("UPDATE user_games SET hours_played = :hours_played WHERE id = :id");
        $stmt->bindParam(':hours_played', $hoursPlayed);
        $stmt->bindParam(':id', $userGameId);
        return $stmt->execute();
    }

    // Supprimer un jeu de la bibliothèque d'un utilisateur
    public function deleteGame($userGameId) {
        $stmt = $this->pdo->prepare("DELETE FROM user_games WHERE id = :id");
        $stmt->bindParam(':id', $userGameId);
        return $stmt->execute();
    }

    // Récupérer les jeux d'un utilisateur
    public function getUserGames($userId) {
        $stmt = $this->pdo->prepare("SELECT g.id, g.title, g.publisher, g.release_date, g.cover_image, ug.hours_played 
                                     FROM user_games ug
                                     JOIN games g ON ug.game_id = g.id
                                     WHERE ug.user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

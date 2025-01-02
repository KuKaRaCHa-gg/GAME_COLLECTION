<?php
class GameController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addGame() {
        // Logique pour ajouter un jeu
        echo "Méthode addGame appelée";
    }

    public function getUserGames($userId) {
        // Exemple de méthode pour récupérer les jeux d'un utilisateur
        $stmt = $this->pdo->prepare("SELECT * FROM LIBRARY WHERE id_user = :id_user");
        $stmt->execute([':id_user' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

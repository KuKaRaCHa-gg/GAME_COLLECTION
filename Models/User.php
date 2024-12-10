<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Vérifie les identifiants
    public function checkCredentials($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM UTILISATEUR WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Retourne les infos de l'utilisateur si le mot de passe est correct
        }
        return false;
    }
}
?>

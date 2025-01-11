<?php

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($data) {
        if (!empty($data['email']) && !empty($data['password'])) {
            require_once 'Models/User.php';
            loginUser($this->pdo, htmlspecialchars($data['email']), htmlspecialchars($data['password']));
        } else {
            echo '<p>Veuillez remplir tous les champs</p>';
        }
    }

    public function register($data) {
        if (!empty($data['password']) && $data['password'] === $data['confirm_password']) {
            require_once 'Models/User.php';
            if (!verifiAdresseMail($this->pdo, $data['email'])) {
                createUser(
                    $this->pdo,
                    htmlspecialchars($data['nom']),
                    htmlspecialchars($data['prenom']),
                    htmlspecialchars($data['email']),
                    htmlspecialchars($data['password'])
                );
                
                loginUser($this->pdo, $data['email'], $data['password']);
            } else {
                echo '<p>Un utilisateur avec cet email existe déjà</p>';
            }
        } else {
            echo '<p>Les mots de passe ne correspondent pas</p>';
        }
    }

    public function logout() {
        require_once 'Models/User.php';
        logout();
    }

    public function showProfile() {
        require_once 'Models/User.php';
        $user = getUser($this->pdo, $_SESSION['user_id']);
        $pdo = $this->pdo;
        require_once 'Views/profile_view.php';
    }
    
    public function updateProfile($id, $data) {
        require_once 'Models/User.php';
        gestionMDP($this->pdo,$id,$data['password'],$data['password_confirm'],$data['nom_user'],$data['pren_user'],$data['mail_user']);
    }

    public function deleteProfile($id) {
        require_once 'Models/User.php';
        deleteUser($this->pdo, $id);
    }
}

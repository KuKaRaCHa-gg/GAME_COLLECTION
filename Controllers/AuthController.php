<?php

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Handle user login
    public function login($data) {
        if (!empty($data['email']) && !empty($data['password'])) {
            require_once 'Models/User.php';
            loginUser($this->pdo, htmlspecialchars($data['email']), htmlspecialchars($data['password']));
        } else {
            echo '<p>Veuillez remplir tous les champs</p>';
        }
    }

    // Handle user registration
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
                // Automatically log in the user after registration
                loginUser($this->pdo, $data['email'], $data['password']);
            } else {
                echo '<p>Un utilisateur avec cet email existe déjà</p>';
            }
        } else {
            echo '<p>Les mots de passe ne correspondent pas</p>';
        }
    }

    // Handle user logout
    public function logout() {
        require_once 'Models/User.php';
        logout();
    }

    // Show user profile
    public function showProfile() {
        require_once 'Models/User.php';
        $user = getUser($this->pdo, $_SESSION['user_id']);
        $pdo = $this->pdo; // Passe $pdo à la vue
        require_once 'Views/profile_view.php';
    }
    

    // Update user profile
    public function updateProfile($id, $data) {
        require_once 'Models/User.php';
        gestionMDP($this->pdo,$id,$data['password'],$data['password_confirm'],$data['nom_user'],$data['pren_user'],$data['mail_user']);
    }

    // Delete user profile
    public function deleteProfile($id) {
        require_once 'Models/User.php';
        deleteUser($this->pdo, $id);
    }
}

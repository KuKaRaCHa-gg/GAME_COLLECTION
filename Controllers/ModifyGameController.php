<?php
require_once 'Models/UserGame.php';

class ModifyGameController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showGame($game) {
        $game = getSpecificGame($this->pdo, $game);
        $pdo = $this->pdo;
        require_once 'Views/ModifyGameView.php';
    }

    public function addTime($id, $time) {
        addTime($this->pdo, $id, $time);
    }

    public function verifiUser($game, $id) {
        $game = getSpecificGame($this->pdo, $game);
        if ($game['id_user'] != $id) {
            header('Location: home');
        }
    }

    public function deleteGame($game) {
        deleteGame($this->pdo, $game);
        header('Location: home');
    }
}
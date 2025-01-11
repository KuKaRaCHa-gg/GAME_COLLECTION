<?php
require_once 'Models/UserGame.php';
require_once 'Models/fonctionDB.php';

class RankingController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showRanking() {
        $pdo = $this->pdo;
        require_once 'Views/ranking_view.php';
    }
}
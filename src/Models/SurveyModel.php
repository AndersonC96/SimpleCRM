<?php
    require_once 'model/Database.php';
    class SurveyModel {
        private $db;
        public function __construct() {
            $this->db = Database::getConnection();
        }
        public function saveResponse($rating, $comment) {
            $stmt = $this->db->prepare("INSERT INTO responses (rating, comment, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$rating, $comment]);
        }
        public function getAllResponses() {
            $stmt = $this->db->query("SELECT * FROM responses ORDER BY created_at DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function calculateNPS() {
            $stmt = $this->db->query("SELECT rating FROM responses");
            $ratings = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $promoters = count(array_filter($ratings, fn($r) => $r >= 9));
            $passives   = count(array_filter($ratings, fn($r) => $r >= 7 && $r <= 8));
            $detractors = count(array_filter($ratings, fn($r) => $r <= 6));
            $total      = count($ratings);
            return $total > 0 ? round((($promoters - $detractors) / $total) * 100) : 0;
        }
    }
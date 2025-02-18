<?php
    class ApiController {
        public function getCampaigns() {
            header('Content-Type: application/json');
            require_once 'app/models/Campaign.php';
            $campaigns = Campaign::getAll();
            echo json_encode($campaigns);
        }
    }
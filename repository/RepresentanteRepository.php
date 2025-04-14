<?php
    namespace App\Repository;
    use App\Config\Database;
    class RepresentanteRepository {
        private \PDO $pdo;
        public function __construct() {
            $this->pdo = Database::connect();
        }
        public function listarTodos(): array {
            return $this->pdo->query("SELECT id, nome FROM representantes ORDER BY nome")->fetchAll();
        }
    }
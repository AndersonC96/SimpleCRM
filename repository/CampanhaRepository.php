<?php
    namespace App\Repository;
    use App\Config\Database;
    class CampanhaRepository {
        private \PDO $pdo;
        public function __construct() {
            $this->pdo = Database::connect();
        }
        public function listar(): array {
            return $this->pdo->query("SELECT c.*, t.nome AS template FROM campanhas c LEFT JOIN templates t ON c.template_id = t.id ORDER BY c.data_inicio DESC")->fetchAll();
        }
        public function salvar(array $dados): int {
            $stmt = $this->pdo->prepare("INSERT INTO campanhas (nome, data_inicio, template_id, canal, status) VALUES (:nome, :data_inicio, :template_id, :canal, 'agendada')");
            $stmt->execute($dados);
            return $this->pdo->lastInsertId();
        }
        public function finalizar(int $id): void {
            $this->pdo->prepare("UPDATE campanhas SET status = 'finalizada' WHERE id = :id")
                      ->execute(['id' => $id]);
        }
    }
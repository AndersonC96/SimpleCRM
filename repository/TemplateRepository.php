<?php
    namespace App\Repository;
    use App\Config\Database;
    class TemplateRepository {
        private \PDO $pdo;
        public function __construct() {
            $this->pdo = Database::connect();
        }
        public function listarTodos(): array {
            return $this->pdo->query("SELECT id, nome, versao FROM templates ORDER BY criado_em DESC")->fetchAll();
        }
        public function buscarConteudo(int $id): ?string {
            $stmt = $this->pdo->prepare("SELECT conteudo_html FROM templates WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch();
            return $result['conteudo_html'] ?? null;
        }
    }
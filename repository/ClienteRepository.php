<?php
    namespace App\Repository;
    use App\Config\Database;
    class ClienteRepository {
        private \PDO $pdo;
        public function __construct() {
            $this->pdo = Database::connect();
        }
        public function listarTodos(): array {
            return $this->pdo->query("SELECT c.*, r.nome AS representante FROM clientes c LEFT JOIN representantes r ON c.representante_id = r.id ORDER BY c.nome")->fetchAll();
        }
        public function buscarPorId(int $id): ?array {
            $stmt = $this->pdo->prepare("SELECT * FROM clientes WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch() ?: null;
        }
        public function salvar(array $dados): bool {
            $stmt = $this->pdo->prepare("INSERT INTO clientes (nome, telefone, email, tags, representante_id) VALUES (:nome, :telefone, :email, :tags, :representante_id)");
            return $stmt->execute($dados);
        }
    }
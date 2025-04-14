<?php
    namespace App\Repository;
    use App\Config\Database;
    class UserRepository {
        private \PDO $pdo;
        public function __construct() {
            $this->pdo = Database::connect();
        }
        public function listarTodos(): array {
            return $this->pdo->query("SELECT id, nome, email, tipo, ativo FROM users ORDER BY nome")->fetchAll();
        }
        public function buscarPorEmail(string $email): ?array {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            return $stmt->fetch() ?: null;
        }
        public function salvar(array $dados): bool {
            $stmt = $this->pdo->prepare("INSERT INTO users (nome, email, senha, tipo, ativo) VALUES (:nome, :email, :senha, :tipo, :ativo)");
            return $stmt->execute($dados);
        }
    }
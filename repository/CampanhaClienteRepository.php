<?php
    namespace App\Repository;
    use App\Config\Database;
    class CampanhaClienteRepository {
        private \PDO $pdo;
        public function __construct() {
            $this->pdo = Database::connect();
        }
        public function associarCliente(array $dados): void {
            $stmt = $this->pdo->prepare("INSERT INTO campanha_clientes (campanha_id, cliente_id, agendado_para, status) VALUES (:campanha_id, :cliente_id, :agendado_para, 'pendente')");
            $stmt->execute($dados);
        }
        public function buscarPendentes(int $campanhaId): array {
            $stmt = $this->pdo->prepare("SELECT cc.id AS cc_id, cl.nome, cl.telefone FROM campanha_clientes cc JOIN clientes cl ON cc.cliente_id = cl.id WHERE cc.campanha_id = :id AND cc.status = 'pendente'");
            $stmt->execute(['id' => $campanhaId]);
            return $stmt->fetchAll();
        }
        public function atualizarStatus(int $id, string $status): void {
            $this->pdo->prepare("UPDATE campanha_clientes SET status = :status, enviado_em = NOW() WHERE id = :id")->execute([
                'status' => $status,
                'id' => $id
            ]);
        }
        public function listarStatusPorCampanha(int $campanhaId): array {
            $stmt = $this->pdo->prepare("SELECT cl.nome, cl.telefone, cc.status, cc.enviado_em FROM campanha_clientes cc JOIN clientes cl ON cl.id = cc.cliente_id WHERE cc.campanha_id = :id");
            $stmt->execute(['id' => $campanhaId]);
            return $stmt->fetchAll();
        }
    }
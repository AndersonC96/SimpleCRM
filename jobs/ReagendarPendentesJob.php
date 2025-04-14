<?php
    namespace App\Job;
    use App\Config\Database;
    class ReagendarPendentesJob {
        public function executar(): void {
            $pdo = Database::connect();
            $hoje = date('Y-m-d');
            $stmt = $pdo->prepare("UPDATE campanha_clientes SET agendado_para = :hoje WHERE status = 'pendente' AND agendado_para < :hoje");
            $stmt->execute(['hoje' => $hoje]);
            echo "Clientes pendentes reagendados para hoje.\n";
        }
    }
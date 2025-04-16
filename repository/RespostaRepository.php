<?php
    namespace App\Repository;
    use PDO;
    use App\Core\Database;
    class RespostaRepository {
        private PDO $pdo;
        public function __construct() {
            $this->pdo = Database::getInstance();
        }
        public function calcularMediaNPSUltimosDias(int $dias = 30): float {
            $sql = "SELECT AVG(nota) as media FROM nps_respostas WHERE data_resposta >= DATE_SUB(NOW(), INTERVAL $dias DAY)";
            $stmt = $this->pdo->query($sql);
            return round($stmt->fetchColumn() ?? 0, 1);
        }
        public function calcularMediaNPSPeriodo(string $inicio, string $fim): float {
            $sql = "SELECT AVG(nota) as media FROM nps_respostas WHERE data_resposta BETWEEN DATE_ADD(NOW(), INTERVAL $inicio) AND DATE_ADD(NOW(), INTERVAL $fim)";
            $stmt = $this->pdo->query($sql);
            return round($stmt->fetchColumn() ?? 0, 1);
        }
        public function respostasPorDiaSemana(): array {
            $dias = ['Mon' => 'Seg', 'Tue' => 'Ter', 'Wed' => 'Qua', 'Thu' => 'Qui', 'Fri' => 'Sex', 'Sat' => 'Sáb', 'Sun' => 'Dom'];
            $resultados = array_fill_keys(array_values($dias), 0);
            $sql = "SELECT DATE_FORMAT(data_resposta, '%a') as dia, COUNT(*) as total FROM nps_respostas WHERE data_resposta >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY dia";
            $stmt = $this->pdo->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $label = $dias[$row['dia']] ?? $row['dia'];
                $resultados[$label] = (int) $row['total'];
            }
            return $resultados;
        }
    }
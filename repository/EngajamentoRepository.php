<?php
    namespace App\Repository;
    use App\Core\Database;
    class EngajamentoRepository {
        public static function obterResumo(): array {
            $pdo = Database::connect();
            // Total de envios que saíram da fila (status ≠ pendente)
            $totais = $pdo->query("SELECT COUNT(*) AS total_enviados FROM campanha_clientes WHERE status != 'pendente'")->fetch(\PDO::FETCH_ASSOC);
            // Total de respostas reais (baseadas na tabela de resposta)
            $respostas = $pdo->query("SELECT COUNT(*) AS total_respondidos FROM nps_respostas")->fetch(\PDO::FETCH_ASSOC);
            return [
                'total' => [
                    'total_enviados' => $totais['total_enviados'] ?? 0,
                    'total_respondidos' => $respostas['total_respondidos'] ?? 0
                ]
            ];
        }
        public static function respostasPorDia(): array {
            $pdo = Database::connect();
            $stmt = $pdo->query("SELECT DAYNAME(data_resposta) AS dia, COUNT(*) AS total FROM nps_respostas WHERE data_resposta IS NOT NULL GROUP BY DAYOFWEEK(data_resposta)");
            $dias = [
                'Monday' => 0, 'Tuesday' => 1, 'Wednesday' => 2, 'Thursday' => 3, 'Friday' => 4, 'Saturday' => 5, 'Sunday' => 6
            ];
            $data = array_fill_keys(array_keys($dias), 0);
            foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
                $data[$row['dia']] = (int) $row['total'];
            }
            // Reordenar para segunda a domingo
            uksort($data, function ($a, $b) use ($dias) {
                return $dias[$a] <=> $dias[$b];
            });
            return $data;
        }
    }
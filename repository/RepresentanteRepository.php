<?php
    namespace App\Repository;
    use App\Core\Database;
    class RepresentanteRepository {
        public static function listarComDadosNPS(): array {
            $pdo = Database::connect();
            $stmt = $pdo->query("SELECT r.id, r.nome, r.area_atuacao, r.imagem_url, ROUND(AVG(n.nota), 1) AS nps, COUNT(n.id) AS total_respostas FROM representantes r LEFT JOIN clientes c ON c.representante_id = r.id LEFT JOIN campanha_clientes cc ON cc.cliente_id = c.id LEFT JOIN nps_respostas n ON n.campanha_id = cc.id GROUP BY r.id");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        public static function listarAreas(): array {
            $pdo = Database::connect();
            $stmt = $pdo->query("SELECT DISTINCT area_atuacao FROM representantes WHERE area_atuacao IS NOT NULL");
            return $stmt->fetchAll(\PDO::FETCH_COLUMN);
        }
    }
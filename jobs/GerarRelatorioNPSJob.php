<?php
    namespace App\Job;
    use App\Config\Database;
    class GerarRelatorioNPSJob {
        public function executar(int $campanhaId): void {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("SELECT cl.nome, cl.email, cc.resposta, r.nota, r.comentario, r.data_resposta FROM nps_respostas r JOIN campanha_clientes cc ON cc.id = r.campanha_cliente_id JOIN clientes cl ON cl.id = cc.cliente_id WHERE cc.campanha_id = :id");
            $stmt->execute(['id' => $campanhaId]);
            $dados = $stmt->fetchAll();
            $filename = "relatorio_nps_campanha_$campanhaId.csv";
            header('Content-Type: text/csv');
            header("Content-Disposition: attachment;filename=$filename");
            $f = fopen('php://output', 'w');
            fputcsv($f, ['Nome', 'Email', 'Nota', 'Comentário', 'Resposta', 'Data']);
            foreach ($dados as $d) {
                fputcsv($f, [
                    $d['nome'],
                    $d['email'],
                    $d['nota'],
                    $d['comentario'],
                    $d['resposta'],
                    date('d/m/Y H:i', strtotime($d['data_resposta']))
                ]);
            }
            fclose($f);
            exit;
        }
    }
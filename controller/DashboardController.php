<?php
    namespace App\Controller;
    use App\Core\View;
    use App\Repository\RepresentanteRepository;
    use App\Repository\EngajamentoRepository;
    use App\Repository\RespostaRepository;
    use App\Repository\CampanhaRepository;
    class DashboardController {
        public function index() {
            if (!isset($_SESSION['usuario'])) {
                header("Location: index.php?url=login");
                exit;
            }
            /*View::render('dashboard/index', ['usuario' => $_SESSION['usuario']]);*/
            $representantes = RepresentanteRepository::listarComDadosNPS();
            $areas = RepresentanteRepository::listarAreas();
            $resumo = EngajamentoRepository::obterResumo();
            $respostasSemana = EngajamentoRepository::respostasPorDia();

            $campanhaRepo = new CampanhaRepository();
            $respostaRepo = new RespostaRepository();

             // NPS atual (últimos 30 dias)
            $mediaAtual = $respostaRepo->calcularMediaNPSUltimosDias(30);

            // NPS anterior (31 a 60 dias atrás)
            //$mediaAnterior = $respostaRepo->calcularMediaNPSPeriodo("-60 days", "-31 days");
            $mediaAnterior = $respostaRepo->calcularMediaNPSPeriodo("-60 DAY", "-31 DAY");

            // Cálculo da variação (percentual de crescimento ou redução)
            $variacao = ($mediaAnterior != 0)
                ? (($mediaAtual / $mediaAnterior) * 100) - 100
                : 0;

            $data = [
                'resumo'           => $resumo,
                'respostasSemana'  => $respostasSemana,
                'representantes'   => $representantes,
                'areas'            => $areas,
    
                // Novos dados relacionados ao NPS
                'mediaNPS'         => $mediaAtual,
                'variacao'         => $variacao,
                'benchmarkFixo'    => 80, // ou o valor que desejar
            ];

            /*View::render('dashboard/index', [
                'resumo' => $resumo,
                'respostasSemana' => $respostasSemana,
                'representantes' => $representantes,
                'areas'=> $areas,
            ]);*/

            View::render('dashboard/index', $data);
        }
    }
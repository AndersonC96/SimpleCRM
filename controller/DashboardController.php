<?php
    namespace App\Controller;
    use App\Core\View;
    use App\Repository\RepresentanteRepository;
    class DashboardController {
        public function index() {
            if (!isset($_SESSION['usuario'])) {
                header("Location: index.php?url=login");
                exit;
            }
            /*View::render('dashboard/index', ['usuario' => $_SESSION['usuario']]);*/
            $representantes = RepresentanteRepository::listarComDadosNPS();
            $areas = RepresentanteRepository::listarAreas();
            View::render('dashboard/index', compact('representantes', 'areas'));
        }
    }
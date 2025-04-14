<?php
    namespace App\Controller;
    use App\Core\View;
    class DashboardController {
        public function index() {
            if (!isset($_SESSION['usuario'])) {
                header("Location: index.php?url=login");
                exit;
            }
            View::render('dashboard/index', ['usuario' => $_SESSION['usuario']]);
        }
    }
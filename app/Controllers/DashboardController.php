<?php
    namespace App\Controllers;
    use App\Models\Survey;
    use App\Models\User;
    class DashboardController extends BaseController {
        /**
        * Exibe a página do dashboard com os KPIs.
        */
        public function index() {
            // Exemplo de KPIs: total de usuários e pesquisas realizadas
            $kpis = [
                'total_users'   => User::count(),
                'total_surveys' => Survey::count(),
                // Outros indicadores podem ser adicionados aqui
            ];
            $this->render('dashboard', ['kpis' => $kpis]);
        }
    }
<?php
    class DashboardModel {
        /**
        * Retorna as estatísticas gerais do sistema.
        *
        * Calcula o total de usuários, clientes e campanhas cadastrados.
        *
        * @return array Associativo contendo as estatísticas ou um array vazio em caso de erro.
        */
        public static function getStatistics() {
            try {
                $db = Database::getConnection();
                // Consulta para contar o total de usuários
                $stmtUsers = $db->query("SELECT COUNT(*) AS total_users FROM users");
                $usersData = $stmtUsers->fetch(PDO::FETCH_ASSOC);
                $totalUsers = isset($usersData['total_users']) ? (int)$usersData['total_users'] : 0;
                // Consulta para contar o total de clientes
                $stmtClients = $db->query("SELECT COUNT(*) AS total_clients FROM clients");
                $clientsData = $stmtClients->fetch(PDO::FETCH_ASSOC);
                $totalClients = isset($clientsData['total_clients']) ? (int)$clientsData['total_clients'] : 0;
                // Consulta para contar o total de campanhas
                $stmtCampaigns = $db->query("SELECT COUNT(*) AS total_campaigns FROM campaigns");
                $campaignsData = $stmtCampaigns->fetch(PDO::FETCH_ASSOC);
                $totalCampaigns = isset($campaignsData['total_campaigns']) ? (int)$campaignsData['total_campaigns'] : 0;
                return [
                    'total_users'     => $totalUsers,
                    'total_clients'   => $totalClients,
                    'total_campaigns' => $totalCampaigns
                ];
            } catch (Exception $e) {
                // Opcional: você pode logar o erro aqui para análise.
                return [];
            }
        }
        /**
        * Calcula ou retorna o NPS (Net Promoter Score).
        *
        * O NPS é calculado com base nas respostas da pesquisa (tabela surveys).
        * Considera-se:
        *   - Promotores: respostas com nota 9 ou 10.
        *   - Detratores: respostas com nota entre 0 e 6.
        *   - Neutros: respostas com nota 7 ou 8 (não são utilizados no cálculo).
        *
        * O NPS é dado por: (% Promotores - % Detratores) * 100.
        *
        * @return float|false Retorna o NPS calculado (valor arredondado) ou false se não houver respostas ou ocorrer um erro.
        */
        public static function calculateNPS() {
            try {
                $db = Database::getConnection();
                $stmt = $db->query("SELECT SUM(CASE WHEN rating >= 9 THEN 1 ELSE 0 END) AS promoters, SUM(CASE WHEN rating <= 6 THEN 1 ELSE 0 END) AS detractors, COUNT(*) AS total FROM surveys");
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                // Verifica se houve respostas
                if (!$result || (int)$result['total'] === 0) {
                    return false;
                }
                $promoters  = (int)$result['promoters'];
                $detractors = (int)$result['detractors'];
                $total      = (int)$result['total'];
                // Calcula a porcentagem de promotores e detratores
                $percentPromoters = $promoters / $total;
                $percentDetractors = $detractors / $total;
                // Calcula o NPS
                $nps = ($percentPromoters - $percentDetractors) * 100;
                // Arredonda o NPS para duas casas decimais
                return round($nps, 2);
            } catch (Exception $e) {
                // Opcional: log do erro pode ser feito aqui.
                return false;
            }
        }
    }
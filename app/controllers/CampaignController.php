<?php
    class CampaignController {
        /**
         * Lista todas as campanhas/pesquisas.
        */
        public function index() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Inclui o modelo de Campaign
            require_once 'app/models/Campaign.php';
            try {
                // Busca todas as campanhas do banco de dados
                $campaigns = Campaign::getAll();
            } catch (Exception $e) {
                $_SESSION['errors'][] = "Erro ao buscar campanhas: " . $e->getMessage();
                $campaigns = [];
            }
            // A variável $campaigns estará disponível na view
            require 'app/views/campaign/index.php';
        }
        /**
         * Cria uma nova campanha.
        */
        public function create() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtém e sanitiza os dados do formulário
                $campaignName = isset($_POST['campaign_name']) ? trim($_POST['campaign_name']) : '';
                $startDate = isset($_POST['start_date']) ? trim($_POST['start_date']) : '';
                $endDate = isset($_POST['end_date']) ? trim($_POST['end_date']) : '';
                $errors = [];
                // Valida os campos obrigatórios
                if (empty($campaignName)) {
                    $errors[] = "O nome da campanha é obrigatório.";
                }
                if (empty($startDate)) {
                    $errors[] = "A data de início é obrigatória.";
                }
                if (empty($endDate)) {
                    $errors[] = "A data de término é obrigatória.";
                }
                // Validação adicional para datas (formato esperado: YYYY-MM-DD)
                if (!empty($startDate)) {
                    $d = DateTime::createFromFormat('Y-m-d', $startDate);
                    if (!($d && $d->format('Y-m-d') === $startDate)) {
                        $errors[] = "Data de início inválida. Formato esperado: YYYY-MM-DD.";
                    }
                }
                if (!empty($endDate)) {
                    $d = DateTime::createFromFormat('Y-m-d', $endDate);
                    if (!($d && $d->format('Y-m-d') === $endDate)) {
                        $errors[] = "Data de término inválida. Formato esperado: YYYY-MM-DD.";
                    }
                }
                // Se houver erros, armazena-os na sessão e redireciona para o formulário de criação
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=campaign/create");
                    exit;
                }
                // Inclui o modelo e tenta criar a campanha
                require_once 'app/models/Campaign.php';
                $result = Campaign::create($campaignName, $startDate, $endDate);
                if (!$result) {
                    $_SESSION['errors'][] = "Erro ao criar campanha.";
                } else {
                    $_SESSION['success_message'] = "Campanha criada com sucesso.";
                }
                header("Location: index.php?url=campaign/index");
                exit;
            }
            // Exibe a view de criação de campanha
            require 'app/views/campaign/create.php';
        }
        /**
         * Edita uma campanha existente identificada por $id.
        */
        public function edit($id) {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Inclui o modelo de Campaign
            require_once 'app/models/Campaign.php';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtém e sanitiza os dados enviados para edição
                $campaignName = isset($_POST['campaign_name']) ? trim($_POST['campaign_name']) : '';
                $startDate = isset($_POST['start_date']) ? trim($_POST['start_date']) : '';
                $endDate = isset($_POST['end_date']) ? trim($_POST['end_date']) : '';
                $errors = [];
                // Valida os campos obrigatórios
                if (empty($campaignName)) {
                    $errors[] = "O nome da campanha é obrigatório.";
                }
                if (empty($startDate)) {
                    $errors[] = "A data de início é obrigatória.";
                }
                if (empty($endDate)) {
                    $errors[] = "A data de término é obrigatória.";
                }
                // Validação de datas
                if (!empty($startDate)) {
                    $d = DateTime::createFromFormat('Y-m-d', $startDate);
                    if (!($d && $d->format('Y-m-d') === $startDate)) {
                        $errors[] = "Data de início inválida. Formato esperado: YYYY-MM-DD.";
                    }
                }
                if (!empty($endDate)) {
                    $d = DateTime::createFromFormat('Y-m-d', $endDate);
                    if (!($d && $d->format('Y-m-d') === $endDate)) {
                        $errors[] = "Data de término inválida. Formato esperado: YYYY-MM-DD.";
                    }
                }
                // Se houver erros, armazena-os e redireciona para o formulário de edição
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=campaign/edit/" . intval($id));
                    exit;
                }
                // Tenta atualizar a campanha
                $result = Campaign::update($id, $campaignName, $startDate, $endDate);
                if (!$result) {
                    $_SESSION['errors'][] = "Erro ao editar campanha.";
                } else {
                    $_SESSION['success_message'] = "Campanha atualizada com sucesso.";
                }
                header("Location: index.php?url=campaign/index");
                exit;
            } else {
                // Para requisições GET, busca os dados da campanha para preencher o formulário
                $campaign = Campaign::find($id);
                if (!$campaign) {
                    $_SESSION['errors'][] = "Campanha não encontrada.";
                    header("Location: index.php?url=campaign/index");
                    exit;
                }
            }
            // Exibe a view de edição de campanha
            require 'app/views/campaign/edit.php';
        }
        /**
         * Exclui uma campanha identificada por $id.
        */
        public function delete($id) {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Inclui o modelo de Campaign
            require_once 'app/models/Campaign.php';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $campaignId = intval($id);
                if ($campaignId <= 0) {
                    $_SESSION['errors'][] = "ID inválido para exclusão.";
                    header("Location: index.php?url=campaign/index");
                    exit;
                }
                // Tenta excluir a campanha
                $result = Campaign::delete($campaignId);
                if (!$result) {
                    $_SESSION['errors'][] = "Erro ao excluir campanha.";
                } else {
                    $_SESSION['success_message'] = "Campanha excluída com sucesso.";
                }
                header("Location: index.php?url=campaign/index");
                exit;
            } else {
                // Se a requisição não for POST, exibe uma view de confirmação (opcional)
                $campaign = Campaign::find($id);
                if (!$campaign) {
                    $_SESSION['errors'][] = "Campanha não encontrada.";
                    header("Location: index.php?url=campaign/index");
                    exit;
                }
                require 'app/views/campaign/delete.php';
            }
        }
    }
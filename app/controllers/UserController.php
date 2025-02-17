<?php
    class UserController {
        /**
         * Construtor: Verifica se o usuário está autenticado.
        * Caso não esteja, redireciona para a página de login.
        */
            public function __construct() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php?url=auth/login");
                exit;
            }
        }
        /**
        * Exibe o painel do usuário com suas campanhas e outras informações.
        */
        public function dashboard() {
            // Inicia a sessão, se ainda não estiver iniciada
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Verifica se o usuário está autenticado
            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php?url=auth/login");
                exit;
            }
            // Inclui o modelo para buscar campanhas (se o usuário tiver campanhas associadas)
            require_once 'app/models/Campaign.php';
            try {
                // Busca as campanhas do usuário utilizando o ID armazenado na sessão
                $campaigns = Campaign::getUserCampaigns($_SESSION['user_id']);
            } catch (Exception $e) {
                // Em caso de erro na busca, armazena uma mensagem de erro e define um array vazio
                $_SESSION['errors'][] = 'Erro ao obter as campanhas: ' . $e->getMessage();
                $campaigns = [];
            }
            // As variáveis, como $campaigns, ficarão disponíveis na view
            require 'app/views/user/dashboard.php';
            }
        /**
        * Exibe o calendário para agendamento de mensagens e processa o agendamento.
        */
        public function schedule() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $errors = [];
                // Obtém e sanitiza os dados do formulário de agendamento
                $scheduleDate = isset($_POST['schedule_date']) ? trim($_POST['schedule_date']) : '';
                $scheduleTime = isset($_POST['schedule_time']) ? trim($_POST['schedule_time']) : '';
                $message      = isset($_POST['message']) ? trim($_POST['message']) : '';
                // Valida a data (formato esperado: YYYY-MM-DD)
                if (empty($scheduleDate)) {
                    $errors[] = "A data de agendamento é obrigatória.";
                } else {
                    $d = DateTime::createFromFormat('Y-m-d', $scheduleDate);
                    if (!($d && $d->format('Y-m-d') === $scheduleDate)) {
                        $errors[] = "Data de agendamento inválida. Formato esperado: YYYY-MM-DD.";
                    }
                }
                // Valida o horário (formato esperado: HH:MM, 24h)
                if (empty($scheduleTime)) {
                    $errors[] = "O horário de agendamento é obrigatório.";
                } else {
                    $t = DateTime::createFromFormat('H:i', $scheduleTime);
                    if (!($t && $t->format('H:i') === $scheduleTime)) {
                        $errors[] = "Horário de agendamento inválido. Formato esperado: HH:MM (24h).";
                    }
                }
                // Valida a mensagem
                if (empty($message)) {
                    $errors[] = "A mensagem é obrigatória.";
                }
                // Se houver erros, armazena-os na sessão e redireciona para a mesma página
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=user/schedule");
                    exit;
                }
                // Processa o agendamento (salva no banco de dados)
                require_once 'app/models/Schedule.php';
                $result = Schedule::create($_SESSION['user_id'], $scheduleDate, $scheduleTime, $message);
                if (!$result) {
                    $_SESSION['errors'] = ["Erro ao agendar a mensagem."];
                } else {
                    $_SESSION['success_message'] = "Mensagem agendada com sucesso.";
                }
                header("Location: index.php?url=user/schedule");
                exit;
            }
            // Exibe a view com o calendário para agendamento
            require 'app/views/user/schedule.php';
        }
        /**
         * Exibe a interface para criação/edição dos templates de mensagem e processa o salvamento.
        */
        public function templates() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $errors = [];
                // Obtém e sanitiza os dados do formulário de template
                $templateName = isset($_POST['template_name']) ? trim($_POST['template_name']) : '';
                $templateContent = isset($_POST['template_content']) ? trim($_POST['template_content']) : '';
                // Valida os campos obrigatórios
                if (empty($templateName)) {
                    $errors[] = "O nome do template é obrigatório.";
                }
                if (empty($templateContent)) {
                    $errors[] = "O conteúdo do template é obrigatório.";
                }
                // Se houver erros, armazena-os na sessão e redireciona para a mesma página
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=user/templates");
                    exit;
                }
                // Salva o template no banco de dados
                require_once 'app/models/Template.php';
                $result = Template::save($_SESSION['user_id'], $templateName, $templateContent);
                if (!$result) {
                    $_SESSION['errors'] = ["Erro ao salvar o template."];
                } else {
                    $_SESSION['success_message'] = "Template salvo com sucesso.";
                }
                header("Location: index.php?url=user/templates");
                exit;
            }
            // Exibe a interface para criação/edição dos templates
            require 'app/views/user/templates.php';
        }
    }
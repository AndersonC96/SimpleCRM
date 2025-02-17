<?php
    class AdminController {
        /**
         * Construtor: Verifica se o usuário está autenticado e possui a role "admin".
        * Caso contrário, redireciona para a página de login.
        */
        public function __construct() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
                header("Location: index.php?url=auth/login");
                exit;
            }
        }
        /**
         * Redireciona para o dashboard do administrador.
        */
        public function index() {
            header("Location: index.php?url=admin/dashboard");
            exit;
        }
        /**
         * Exibe o dashboard do administrador.
        * Aqui podemos incluir a busca dos dados necessários, como estatísticas e NPS.
        */
        public function dashboard() {
            require_once 'app/models/DashboardModel.php';
            try {
                // Busca as estatísticas do sistema (ex.: número de pesquisas, usuários ativos, etc.)
                $stats = DashboardModel::getStatistics();
                // Calcula ou busca o NPS (Net Promoter Score)
                $nps = DashboardModel::calculateNPS();
                // Define valores padrão se os dados não forem válidos
                if (!$stats || !is_array($stats)) {
                    $stats = [];
                }
                if ($nps === null) {
                    $nps = 0;
                }
            } catch (Exception $e) {
                $_SESSION['errors'][] = 'Erro ao carregar as estatísticas: ' . $e->getMessage();
                $stats = [];
                $nps = 0;
            }
            // As variáveis $stats e $nps estarão disponíveis na view
            require 'app/views/admin/dashboard.php';
        }
        /**
         * Gerencia usuários.
        * Processa ações de criação, edição e exclusão e exibe a view de gerenciamento de usuários.
        */
        public function manage_users() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $action = isset($_POST['action']) ? $_POST['action'] : '';
                require_once 'app/models/User.php';
                if ($action == 'create') {
                    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
                    $email    = isset($_POST['email']) ? trim($_POST['email']) : '';
                    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
                    $errors = [];
                    // Validações dos campos
                    if (empty($username)) {
                        $errors[] = 'O nome do usuário é obrigatório.';
                    }
                    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = 'Email inválido.';
                    }
                    if (empty($password)) {
                        $errors[] = 'A senha é obrigatória.';
                    }
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header("Location: index.php?url=admin/manage_users");
                        exit;
                    }
                    $result = User::create($username, $email, password_hash($password, PASSWORD_DEFAULT));
                    if (!$result) {
                        $_SESSION['errors'] = ['Erro ao criar usuário.'];
                    } else {
                        $_SESSION['success_message'] = 'Usuário criado com sucesso.';
                    }
                    header("Location: index.php?url=admin/manage_users");
                    exit;
                } elseif ($action == 'edit') {
                    $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
                    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
                    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
                    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
                    $errors = [];
                    if ($userId <= 0) {
                        $errors[] = 'ID de usuário inválido para edição.';
                    }
                    if (empty($username)) {
                        $errors[] = 'O nome do usuário é obrigatório.';
                    }
                    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = 'Email inválido.';
                    }
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header("Location: index.php?url=admin/manage_users");
                        exit;
                    }
                    // Se a senha for informada, atualiza; caso contrário, mantém a senha atual
                    $passwordHash = (!empty($password)) ? password_hash($password, PASSWORD_DEFAULT) : null;
                    $result = User::update($userId, $username, $email, $passwordHash);
                    if (!$result) {
                        $_SESSION['errors'] = ['Erro ao editar usuário.'];
                    } else {
                        $_SESSION['success_message'] = 'Usuário atualizado com sucesso.';
                    }
                    header("Location: index.php?url=admin/manage_users");
                    exit;
                } elseif ($action == 'delete') {
                    $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
                    if ($userId <= 0) {
                        $_SESSION['errors'] = ['ID inválido para exclusão.'];
                        header("Location: index.php?url=admin/manage_users");
                        exit;
                    }
                    $result = User::delete($userId);
                    if (!$result) {
                        $_SESSION['errors'] = ['Erro ao excluir usuário.'];
                    } else {
                        $_SESSION['success_message'] = 'Usuário excluído com sucesso.';
                    }
                    header("Location: index.php?url=admin/manage_users");
                    exit;
                }
            }
            require 'app/views/admin/manage_users.php';
        }
        /**
         * Gerencia clientes.
        * Processa ações de criação, edição e exclusão e exibe a view de gerenciamento de clientes.
        */
        public function manage_clients() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $action = isset($_POST['action']) ? $_POST['action'] : '';
                require_once 'app/models/Client.php';
                if ($action == 'create') {
                    $clientName    = isset($_POST['client_name']) ? trim($_POST['client_name']) : '';
                    $clientContact = isset($_POST['client_contact']) ? trim($_POST['client_contact']) : '';
                    $errors = [];
                    if (empty($clientName)) {
                        $errors[] = 'O nome do cliente é obrigatório.';
                    }
                    if (empty($clientContact)) {
                        $errors[] = 'O contato do cliente é obrigatório.';
                    }
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header("Location: index.php?url=admin/manage_clients");
                        exit;
                    }
                    $result = Client::create($clientName, $clientContact);
                    if (!$result) {
                        $_SESSION['errors'] = ['Erro ao criar cliente.'];
                    } else {
                        $_SESSION['success_message'] = 'Cliente criado com sucesso.';
                    }
                    header("Location: index.php?url=admin/manage_clients");
                    exit;
                } elseif ($action == 'edit') {
                    $clientId = isset($_POST['client_id']) ? intval($_POST['client_id']) : 0;
                    $clientName = isset($_POST['client_name']) ? trim($_POST['client_name']) : '';
                    $clientContact = isset($_POST['client_contact']) ? trim($_POST['client_contact']) : '';
                    $errors = [];
                    if ($clientId <= 0) {
                        $errors[] = 'ID de cliente inválido.';
                    }
                    if (empty($clientName)) {
                        $errors[] = 'O nome do cliente é obrigatório.';
                    }
                    if (empty($clientContact)) {
                        $errors[] = 'O contato do cliente é obrigatório.';
                    }
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header("Location: index.php?url=admin/manage_clients");
                        exit;
                    }
                    $result = Client::update($clientId, $clientName, $clientContact);
                    if (!$result) {
                        $_SESSION['errors'] = ['Erro ao editar cliente.'];
                    } else {
                        $_SESSION['success_message'] = 'Cliente atualizado com sucesso.';
                    }
                    header("Location: index.php?url=admin/manage_clients");
                    exit;
                } elseif ($action == 'delete') {
                    $clientId = isset($_POST['client_id']) ? intval($_POST['client_id']) : 0;
                    if ($clientId <= 0) {
                        $_SESSION['errors'] = ['ID inválido para exclusão.'];
                        header("Location: index.php?url=admin/manage_clients");
                        exit;
                    }
                    $result = Client::delete($clientId);
                    if (!$result) {
                        $_SESSION['errors'] = ['Erro ao excluir cliente.'];
                    } else {
                        $_SESSION['success_message'] = 'Cliente excluído com sucesso.';
                    }
                    header("Location: index.php?url=admin/manage_clients");
                    exit;
                }
            }
            require 'app/views/admin/manage_clients.php';
        }
        /**
         * Gerencia campanhas/pesquisas.
        * Processa formulários de criação/edição e exibe a view de gerenciamento de campanhas.
        */
        public function manage_campaigns() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $action = isset($_POST['action']) ? $_POST['action'] : '';
                if ($action == 'create') {
                    $campaignName = isset($_POST['campaign_name']) ? trim($_POST['campaign_name']) : '';
                    $startDate = isset($_POST['start_date']) ? trim($_POST['start_date']) : '';
                    $endDate = isset($_POST['end_date']) ? trim($_POST['end_date']) : '';
                    $errors = [];
                    if (empty($campaignName)) {
                        $errors[] = 'O nome da campanha é obrigatório.';
                    }
                    if (empty($startDate)) {
                        $errors[] = 'A data de início é obrigatória.';
                    }
                    if (empty($endDate)) {
                        $errors[] = 'A data de término é obrigatória.';
                    }
                    // Podemos adicionar validações adicionais para datas podem ser implementada aqui.
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header("Location: index.php?url=admin/manage_campaigns");
                        exit;
                    }
                    require_once 'app/models/Campaign.php';
                    $result = Campaign::create($campaignName, $startDate, $endDate);
                    if (!$result) {
                        $_SESSION['errors'] = ['Erro ao criar campanha.'];
                    } else {
                        $_SESSION['success_message'] = 'Campanha criada com sucesso.';
                    }
                    header("Location: index.php?url=admin/manage_campaigns");
                    exit;
                }
                // Podemos implementar outras ações (edit, delete, etc.) aqui.
            }
            require 'app/views/admin/manage_campaigns.php';
        }
        /**
         * Exibe os logs e histórico de atividades.
        * Pode aplicar filtros via GET, se necessário.
        */
        public function logs() {
            $logs = []; // Valor padrão, caso não haja logs
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                // Obtém e sanitiza o filtro (se informado)
                $filter = isset($_GET['filter']) ? trim($_GET['filter']) : '';
                // Inclui o modelo de logs
                require_once 'app/models/LogsModel.php';
                try {
                    // Busca os logs utilizando o filtro (o método getLogs deve ser implementado no modelo)
                    $logs = LogsModel::getLogs($filter);
                } catch (Exception $e) {
                    // Em caso de erro, armazena a mensagem na sessão (ou em outra variável para a view)
                    $_SESSION['errors'][] = 'Erro ao carregar os logs: ' . $e->getMessage();
                }
            }
            // As variáveis, como $logs, estarão disponíveis na view de logs
            require 'app/views/admin/logs.php';
        }
    }
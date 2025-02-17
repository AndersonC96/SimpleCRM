<?php
    class ClientController {
        /**
         * Lista todos os clientes cadastrados.
        */
        public function index() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Inclui o modelo de Cliente
            require_once 'app/models/Client.php';
            try {
                // Busca todos os clientes do banco de dados
                $clients = Client::getAll();
            } catch (Exception $e) {
                $_SESSION['errors'][] = "Erro ao buscar clientes: " . $e->getMessage();
                $clients = [];
            }
            // As variáveis, como $clients, estarão disponíveis na view
            require 'app/views/client/index.php';
        }
        /**
         * Processa a criação de um novo cliente.
        */
        public function create() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtém e sanitiza os dados do formulário
                $clientName = isset($_POST['client_name']) ? trim($_POST['client_name']) : '';
                $clientContact = isset($_POST['client_contact']) ? trim($_POST['client_contact']) : '';
                $errors = [];
                // Valida os campos obrigatórios
                if (empty($clientName)) {
                    $errors[] = "O nome do cliente é obrigatório.";
                }
                if (empty($clientContact)) {
                    $errors[] = "O contato do cliente é obrigatório.";
                }
                // Se houver erros, armazena-os na sessão e redireciona de volta ao formulário
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=client/create");
                    exit;
                }
                // Inclui o modelo de Cliente
                require_once 'app/models/Client.php';
                $result = Client::create($clientName, $clientContact);
                // Define mensagem de sucesso ou erro
                if (!$result) {
                    $_SESSION['errors'] = ["Erro ao criar cliente."];
                } else {
                    $_SESSION['success_message'] = "Cliente criado com sucesso.";
                }
                header("Location: index.php?url=client/index");
                exit;
            }
            // Exibe a view de criação de cliente
            require 'app/views/client/create.php';
        }
        /**
         * Processa a edição de um cliente identificado por $id.
        */
        public function edit($id) {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Inclui o modelo de Cliente
            require_once 'app/models/Client.php';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtém e sanitiza os dados enviados para edição
                $clientName = isset($_POST['client_name']) ? trim($_POST['client_name']) : '';
                $clientContact = isset($_POST['client_contact']) ? trim($_POST['client_contact']) : '';
                $errors = [];
                // Valida o ID e os campos obrigatórios
                if (empty($id) || intval($id) <= 0) {
                    $errors[] = "ID de cliente inválido.";
                }
                if (empty($clientName)) {
                    $errors[] = "O nome do cliente é obrigatório.";
                }
                if (empty($clientContact)) {
                    $errors[] = "O contato do cliente é obrigatório.";
                }
                // Se houver erros, armazena-os na sessão e redireciona para o formulário de edição
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=client/edit/" . intval($id));
                    exit;
                }
                // Tenta atualizar o cliente
                $result = Client::update($id, $clientName, $clientContact);
                if (!$result) {
                    $_SESSION['errors'] = ["Erro ao editar cliente."];
                } else {
                    $_SESSION['success_message'] = "Cliente atualizado com sucesso.";
                }
                header("Location: index.php?url=client/index");
                exit;
            } else {
                // Se for GET, busca os dados do cliente para preencher o formulário
                $client = Client::find($id);
                if (!$client) {
                    $_SESSION['errors'][] = "Cliente não encontrado.";
                    header("Location: index.php?url=client/index");
                    exit;
                }
            }
            // Exibe a view de edição com os dados do cliente
            require 'app/views/client/edit.php';
        }
        /**
         * Processa a exclusão de um cliente identificado por $id.
        */
        public function delete($id) {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Inclui o modelo de Cliente
            require_once 'app/models/Client.php';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Valida o ID
                $clientId = intval($id);
                if ($clientId <= 0) {
                    $_SESSION['errors'][] = "ID inválido para exclusão.";
                    header("Location: index.php?url=client/index");
                    exit;
                }
                // Tenta excluir o cliente
                $result = Client::delete($clientId);
                if (!$result) {
                    $_SESSION['errors'][] = "Erro ao excluir cliente.";
                } else {
                    $_SESSION['success_message'] = "Cliente excluído com sucesso.";
                }
                header("Location: index.php?url=client/index");
                exit;
            } else {
                // Se a requisição não for POST, pode exibir uma confirmação de exclusão
                // Exibe a view de confirmação (opcional)
                $client = Client::find($id);
                if (!$client) {
                    $_SESSION['errors'][] = "Cliente não encontrado.";
                    header("Location: index.php?url=client/index");
                    exit;
                }
                require 'app/views/client/delete.php';
            }
        }
    }
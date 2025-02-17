<?php
    class HomeController {
        /**
        * Exibe a página inicial da aplicação.
        */
        public function index() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Aqui você podemos carregar dados específicos para a home, se necessário.
            // Exemplo: promoções, novidades, etc.
            // Inclui a view da página inicial
            require 'app/views/home/index.php';
        }
        /**
        * Exibe uma página "Sobre" com informações sobre a aplicação.
        */
        public function about() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Inclui a view da página "Sobre"
            require 'app/views/home/about.php';
        }
        /**
        * Processa e exibe o formulário de contato.
        * Se a requisição for POST, valida os dados e processa o formulário.
        */
        public function contact() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Se o formulário for enviado via POST, processa os dados
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtém e sanitiza os dados do formulário
                $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
                $email   = isset($_POST['email']) ? trim($_POST['email']) : '';
                $message = isset($_POST['message']) ? trim($_POST['message']) : '';
                $errors = [];
                // Validação do campo "Nome"
                if (empty($name)) {
                    $errors[] = "O campo Nome é obrigatório.";
                } elseif (strlen($name) < 2) {
                    $errors[] = "O nome deve ter pelo menos 2 caracteres.";
                }
                // Validação do campo "Email"
                if (empty($email)) {
                    $errors[] = "O campo Email é obrigatório.";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Email inválido.";
                }
                // Validação do campo "Mensagem"
                if (empty($message)) {
                    $errors[] = "O campo Mensagem é obrigatório.";
                } elseif (strlen($message) > 1000) {
                    $errors[] = "A mensagem deve ter no máximo 1000 caracteres.";
                }
                // Se houver erros, armazena na sessão e redireciona de volta para o formulário de contato
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=home/contact");
                    exit;
                } else {
                    // Aqui podemos processar os dados do formulário (por exemplo, enviar um e-mail ou armazenar em um banco de dados)
                    // Neste exemplo, definiremos apenas uma mensagem de sucesso.
                    $_SESSION['success_message'] = "Sua mensagem foi enviada com sucesso.";
                    header("Location: index.php?url=home/contact");
                    exit;
                }
            }
            // Se não for POST, apenas exibe o formulário de contato
            require 'app/views/home/contact.php';
        }
    }
<?php
    require_once __DIR__ . '/../models/User.php';
    class AuthController {
        /**
        * Exibe o formulário de login e processa a autenticação.
        */
        public function login() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = isset($_POST['username']) ? trim($_POST['username']) : '';
                $password = isset($_POST['password']) ? trim($_POST['password']) : '';
                $errors = [];
                if (empty($username)) {
                    $errors[] = "O campo usuário é obrigatório.";
                }
                if (empty($password)) {
                    $errors[] = "O campo senha é obrigatório.";
                }
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=auth/login");
                    exit;
                }
                $user = User::authenticate($username, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    header("Location: index.php?url=user/dashboard");
                    exit;
                } else {
                    $_SESSION['errors'][] = "Usuário ou senha inválidos.";
                    header("Location: index.php?url=auth/login");
                    exit;
                }
            }
            require 'app/views/auth/login.php';
        }
        /**
        * Exibe o formulário de registro e cria um novo usuário.
        */
        public function register() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = isset($_POST['username']) ? trim($_POST['username']) : '';
                $email = isset($_POST['email']) ? trim($_POST['email']) : '';
                $password = isset($_POST['password']) ? trim($_POST['password']) : '';
                $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
                $errors = [];
                if (empty($username)) {
                    $errors[] = "O campo usuário é obrigatório.";
                }
                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Email inválido.";
                }
                if (empty($password)) {
                    $errors[] = "O campo senha é obrigatório.";
                }
                if ($password !== $confirm_password) {
                    $errors[] = "As senhas não conferem.";
                }
                if (strlen($password) < 6) {
                    $errors[] = "A senha deve ter pelo menos 6 caracteres.";
                }
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=auth/register");
                    exit;
                }
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $id = User::create($username, $email, $passwordHash, 'user');
                if ($id) {
                    $_SESSION['success_message'] = "Registro efetuado com sucesso. Faça login.";
                    header("Location: index.php?url=auth/login");
                    exit;
                } else {
                    $_SESSION['errors'][] = "Falha ao registrar usuário.";
                    header("Location: index.php?url=auth/register");
                    exit;
                }
            }
            require 'app/views/auth/register.php';
        }
        /**
        * Exibe o formulário para recuperação de senha e envia um e-mail com o link de redefinição.
        */
        public function forgot_password() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = isset($_POST['email']) ? trim($_POST['email']) : '';
                $errors = [];
                if (empty($email)) {
                    $errors[] = "O campo de email é obrigatório.";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Formato de email inválido.";
                }
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=auth/forgot_password");
                    exit;
                }
                $user = User::findByEmail($email);
                if ($user) {
                    // Gera token e armazena
                    $token = bin2hex(random_bytes(16));
                    if (User::storeResetToken($user['id'], $token)) {
                        // Exemplo básico de envio de e-mail (substitua pela sua lógica de envio)
                        $to = $user['email'];
                        $subject = "Recuperação de Senha";
                        $message = "Clique no link a seguir para redefinir sua senha: " . BASE_URL . "/index.php?url=auth/reset_password&token=" . urlencode($token);
                        $headers = "From: no-reply@meuprojeto.com\r\n";
                        if (mail($to, $subject, $message, $headers)) {
                            $_SESSION['success_message'] = "Um link de recuperação foi enviado para seu email.";
                        } else {
                            $_SESSION['errors'][] = "Erro ao enviar o email de recuperação.";
                        }
                        header("Location: index.php?url=auth/login");
                        exit;
                    } else {
                        $_SESSION['errors'][] = "Erro ao gerar token de recuperação.";
                        header("Location: index.php?url=auth/forgot_password");
                        exit;
                    }
                } else {
                    $_SESSION['errors'][] = "Nenhum usuário encontrado com esse email.";
                    header("Location: index.php?url=auth/forgot_password");
                    exit;
                }
            }
            require 'app/views/auth/forgot_password.php';
        }
        /**
        * Processa a redefinição da senha.
        */
        public function reset_password() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $token = isset($_POST['token']) ? trim($_POST['token']) : '';
                $password = isset($_POST['password']) ? trim($_POST['password']) : '';
                $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
                $errors = [];
                if (empty($token)) {
                    $errors[] = "Token inválido ou expirado.";
                }
                if (empty($password)) {
                    $errors[] = "A nova senha é obrigatória.";
                }
                if ($password !== $confirm_password) {
                    $errors[] = "As senhas não conferem.";
                }
                if (strlen($password) < 6) {
                    $errors[] = "A senha deve ter no mínimo 6 caracteres.";
                }
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    // Mantenha o token na query string para que o usuário possa tentar novamente
                    header("Location: index.php?url=auth/reset_password&token=" . urlencode($token));
                    exit;
                }
                // Aqui podemos implementar a lógica de encontrar o usuário pelo token e atualizar a senha.
                // Por exemplo:
                // $user = User::findByResetToken($token);
                // if ($user) {
                //     // Atualiza a senha do usuário
                //     $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                //     $result = User::update($user['id'], $user['username'], $user['email'], $passwordHash);
                //     if ($result) {
                //         // Limpe o token e redirecione com sucesso
                //         $_SESSION['success_message'] = "Senha redefinida com sucesso. Faça login.";
                //         header("Location: index.php?url=auth/login");
                //         exit;
                //     } else {
                //         $_SESSION['errors'][] = "Erro ao atualizar a senha.";
                //     }
                // } else {
                //     $_SESSION['errors'][] = "Token inválido ou expirado.";
                // }
                // Se ocorrer erro, redirecione de volta
                header("Location: index.php?url=auth/reset_password&token=" . urlencode($token));
                exit;
            } else {
                // Para requisições GET, verifica se o token foi passado
                $token = isset($_GET['token']) ? trim($_GET['token']) : '';
                if (empty($token)) {
                    $_SESSION['errors'][] = "Token inválido ou expirado.";
                    header("Location: index.php?url=auth/forgot_password");
                    exit;
                }
            }
            require 'app/views/auth/reset_password.php';
        }
        /**
        * Encerra a sessão do usuário e redireciona para a página de login.
        */
        public function logout() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            session_destroy();
            header("Location: index.php?url=auth/login");
            exit;
        }
    }
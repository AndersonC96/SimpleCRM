<?php
    class AuthController {
        /**
         * Exibe o formulário de login e processa a autenticação do usuário.
        */
        public function login() {
            // Verifica se o formulário foi submetido via POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitiza e obtém os dados enviados
                $username = isset($_POST['username']) ? trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)) : '';
                $password = isset($_POST['password']) ? trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)) : '';
                $errors = [];
                // Validação: Verifica se os campos estão preenchidos
                if (empty($username)) {
                    $errors[] = 'O campo de usuário é obrigatório.';
                }
                if (empty($password)) {
                    $errors[] = 'O campo de senha é obrigatório.';
                }
                // Se houver erros, retorna para a view com as mensagens
                if (!empty($errors)) {
                    // A view pode acessar o array $errors para exibir as mensagens
                    require 'app/views/auth/login.php';
                    return;
                }
                // Inclui o modelo do usuário para realizar a autenticação
                require_once 'app/models/User.php';
                // Tenta autenticar o usuário (o método authenticate deve implementar o acesso ao BD)
                $user = User::authenticate($username, $password);
                if ($user) {
                    // Autenticação bem-sucedida: inicia a sessão com os dados do usuário
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    // Redireciona para o painel do usuário ou dashboard
                    header("Location: index.php?url=user/dashboard");
                    exit;
                } else {
                    // Se a autenticação falhar, adiciona mensagem de erro
                    $errors[] = 'Usuário ou senha inválidos.';
                    require 'app/views/auth/login.php';
                    return;
                }
            } else {
                // Se não for POST, exibe o formulário de login
                require 'app/views/auth/login.php';
            }
        }
        /**
         * Exibe o formulário de registro e processa a criação de um novo usuário.
        */
        public function register() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitiza e obtém os dados do formulário
                $username = isset($_POST['username']) ? trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)) : '';
                $password = isset($_POST['password']) ? trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)) : '';
                $confirm_password = isset($_POST['confirm_password']) ? trim(filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING)) : '';
                $errors = [];
                // Validações básicas
                if (empty($username)) {
                    $errors[] = 'O campo de usuário é obrigatório.';
                }
                if (empty($password)) {
                    $errors[] = 'O campo de senha é obrigatório.';
                }
                if (empty($confirm_password)) {
                    $errors[] = 'O campo de confirmação de senha é obrigatório.';
                }
                if ($password !== $confirm_password) {
                    $errors[] = 'As senhas não conferem.';
                }
                if (strlen($password) < 6) {
                    $errors[] = 'A senha deve ter no mínimo 6 caracteres.';
                }
                // Se houver erros, exibe novamente o formulário com mensagens
                if (!empty($errors)) {
                    require 'app/views/auth/register.php';
                    return;
                }
                // Inclui o modelo do usuário para processar o registro
                require_once 'app/models/User.php';
                // Verifica se o usuário já está cadastrado
                if (User::exists($username)) {
                    $errors[] = 'Este usuário já está cadastrado.';
                    require 'app/views/auth/register.php';
                    return;
                }
                // Criptografa a senha antes de salvar
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                // Cria o usuário no banco de dados (o método create deve retornar o ID do novo usuário ou false em caso de falha)
                $newUserId = User::create($username, $hashedPassword);
                if ($newUserId) {
                    // Registro efetuado com sucesso: define mensagem de sucesso e redireciona para a tela de login
                    $_SESSION['success_message'] = 'Registro realizado com sucesso. Por favor, faça login.';
                    header("Location: index.php?url=auth/login");
                    exit;
                } else {
                    $errors[] = 'Erro ao registrar usuário. Tente novamente.';
                    require 'app/views/auth/register.php';
                    return;
                }
            } else {
                // Exibe o formulário de registro se não for POST
                require 'app/views/auth/register.php';
            }
        }
        /**
         * Exibe o formulário de recuperação de senha, processa a geração do token e envia o link de redefinição.
        */
        public function forgot_password() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtém e sanitiza o email
                $email = isset($_POST['email']) ? trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) : '';
                $errors = [];
                // Valida o campo de email
                if (empty($email)) {
                    $errors[] = 'O campo de email é obrigatório.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Formato de email inválido.';
                }
            // Se houver erros de validação, exibe o formulário novamente
                if (!empty($errors)) {
                    require 'app/views/auth/forgot_password.php';
                    return;
                }
                // Inclui o modelo do usuário para buscar o registro pelo email
                require_once 'app/models/User.php';
                // Tenta localizar o usuário pelo email informado
                $user = User::findByEmail($email);
                if ($user) {
                    try {
                        // Gera um token seguro para recuperação de senha
                        $token = bin2hex(random_bytes(16));
                    } catch (Exception $e) {
                        $errors[] = 'Erro ao gerar token seguro.';
                        require 'app/views/auth/forgot_password.php';
                        return;
                    }
                    // Armazena o token no banco de dados (implemente o método storeResetToken em User.php)
                    if (User::storeResetToken($user['id'], $token)) {
                        // Envio de email utilizando PHPMailer
                        require 'vendor/autoload.php';
                        // Cria uma instância do PHPMailer
                        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                        try {
                            // Configurações do servidor SMTP
                            $mail->isSMTP();
                            $mail->Host = 'smtp.seudominio.com';       // Servidor SMTP ainda não escolhido
                            $mail->SMTPAuth = true;
                            $mail->Username = 'seu-email@seudominio.com';    // Usuário SMTP
                            $mail->Password = 'sua-senha';                     // Senha SMTP
                            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;                           // Porta SMTP (geralmente 587 para TLS)
                            // Define o remetente e o destinatário
                            $mail->setFrom('seu-email@seudominio.com', 'Nome da Empresa');
                            $mail->addAddress($user['email'], $user['username']);
                            // Configura o conteúdo do email
                            $mail->isHTML(true);
                            $mail->Subject = 'Recuperação de Senha';
                            // Cria o link para redefinir a senha
                            $resetLink = "http://localhost/crm-satisfacao/?url=auth/reset_password&token=" . urlencode($token);
                            $mail->Body = "Clique no link a seguir para redefinir sua senha: <a href='{$resetLink}'>{$resetLink}</a>";
                            $mail->AltBody = "Clique no link a seguir para redefinir sua senha: {$resetLink}";
                            // Envia o email
                            $mail->send();
                            // Define mensagem de sucesso e redireciona para a página de login
                            $_SESSION['success_message'] = 'Um link de recuperação foi enviado para seu email.';
                            header("Location: index.php?url=auth/login");
                            exit;
                        } catch (PHPMailer\PHPMailer\Exception $e) {
                            $errors[] = 'Erro ao enviar email: ' . $mail->ErrorInfo;
                        }
                    } else {
                        $errors[] = 'Erro ao gerar token de recuperação. Tente novamente.';
                    }
                } else {
                    $errors[] = 'Nenhum usuário encontrado com este email.';
                }
                // Exibe novamente o formulário com os erros, se houver
                require 'app/views/auth/forgot_password.php';
            } else {
                // Se não for uma requisição POST, apenas exibe o formulário de recuperação de senha
                require 'app/views/auth/forgot_password.php';
            }
        }
        /**
         * Encerra a sessão do usuário e redireciona para a página de login.
        */
        public function logout() {
            session_destroy();
            header("Location: index.php?url=auth/login");
            exit;
        }
    }
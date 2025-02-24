<?php
    namespace App\Controllers;
    use App\Models\User;
    class LoginController extends BaseController {
        /**
        * Exibe o formulário de login.
        */
        public function showLoginForm() {
            $this->render('login');
        }
        /**
        * Processa o login do usuário.
        */
        public function login() {
            // Recupera dados do POST
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            // Procura o usuário pelo email (método estático implementado no model)
            $user = User::findByEmail($email);
            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                header('Location: /dashboard');
                exit;
            } else {
                $error = "Credenciais inválidas!";
                $this->render('login', ['error' => $error]);
            }
        }
        /**
        * Efetua o logout do usuário.
        */
        public function logout() {
            session_destroy();
            header('Location: /login');
        }
    }
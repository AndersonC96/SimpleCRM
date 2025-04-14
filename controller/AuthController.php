<?php
    namespace App\Controller;
    use App\Core\View;
    use App\Model\User;
    use App\Config\Database;
    class AuthController {
        public function login() {
            View::render('auth/login');
        }
        public function auth() {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $pdo = Database::connect();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            if ($user && password_verify($senha, $user['senha'])) {
                session_start();
                $_SESSION['usuario'] = $user;
                header("Location: index.php?url=dashboard");
            } else {
                echo "E-mail ou senha inválidos.";
            }
        }
        public function logout() {
            session_start();
            session_destroy();
            header("Location: index.php?url=login");
        }
    }
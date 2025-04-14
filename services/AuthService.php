<?php
    namespace App\Service;
    use App\Config\Database;
    class AuthService {
        public static function login(string $email, string $senha): ?array {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            if ($user && password_verify($senha, $user['senha'])) {
                return $user;
            }
            return null;
        }
        public static function check(): bool {
            session_start();
            return isset($_SESSION['usuario']);
        }
        public static function logout(): void {
            session_start();
            session_destroy();
        }
        public static function isAdmin(): bool {
            return self::check() && $_SESSION['usuario']['tipo'] === 'admin';
        }
    }
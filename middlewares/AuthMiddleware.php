<?php
    namespace App\Middleware;
    class AuthMiddleware {
        public static function check(): void {
            session_start();
            if (!isset($_SESSION['usuario'])) {
                header("Location: index.php?url=login");
                exit;
            }
        }
    }
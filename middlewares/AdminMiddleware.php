<?php
    namespace App\Middleware;
    class AdminMiddleware {
        public static function check(): void {
            session_start();
            if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
                echo "Acesso restrito a administradores.";
                exit;
            }
        }
    }
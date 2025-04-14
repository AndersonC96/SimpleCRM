<?php
    namespace App\Utils;
    class Validador {
        public static function telefoneValido(string $telefone): bool {
            $telefone = preg_replace('/\D/', '', $telefone);
            return preg_match('/^\d{10,11}$/', $telefone);
        }
        public static function emailValido(string $email): bool {
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        }
        public static function campoObrigatorio(string $valor): bool {
            return trim($valor) !== '';
        }
    }
<?php
    namespace App\Utils;
    class Helpers {
        public static function gerarToken(int $tamanho = 32): string {
            return bin2hex(random_bytes($tamanho));
        }
        public static function redirecionar(string $url): void {
            header("Location: $url");
            exit;
        }
        public static function limitarTexto(string $texto, int $limite): string {
            return strlen($texto) > $limite ? substr($texto, 0, $limite) . '...' : $texto;
        }
        public static function session(string $key) {
            return $_SESSION[$key] ?? null;
        }
    }
<?php
    namespace App\Utils;
    class Formatador {
        public static function telefone(string $numero): string {
            $numero = preg_replace('/\D/', '', $numero);
            if (strlen($numero) === 11) {
                return '('.substr($numero, 0, 2).') '.substr($numero, 2, 5).'-'.substr($numero, 7);
            }
            if (strlen($numero) === 10) {
                return '('.substr($numero, 0, 2).') '.substr($numero, 2, 4).'-'.substr($numero, 6);
            }
            return $numero;
        }
        public static function dataBR(string $data): string {
            return date('d/m/Y', strtotime($data));
        }
        public static function dataHoraBR(string $data): string {
            return date('d/m/Y H:i', strtotime($data));
        }
    }
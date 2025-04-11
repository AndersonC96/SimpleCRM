<?php
    namespace Tisim\SimpleCrm\Services;
    class TokenService {
        public static function generate(int $length = 32): string {
            return bin2hex(random_bytes($length / 2));
        }
    }
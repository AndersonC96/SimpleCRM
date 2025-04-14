<?php
    namespace App\Core;
    class View {
        public static function render(string $view, array $data = []): void {
            extract($data);
            $path = __DIR__ . '/../view/' . $view . '.php';
            if (file_exists($path)) {
                include $path;
            } else {
                http_response_code(500);
                echo "View não encontrada: $view";
            }
        }
    }
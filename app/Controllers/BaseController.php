<?php
    namespace Tisim\SimpleCrm\Controllers;
    class BaseController {
        protected function view(string $path, array $data = []) {
            extract($data);
            require __DIR__ . "/../Views/{$path}.php";
        }
        protected function redirect(string $url) {
            header("Location: $url");
            exit;
        }
    }
?>
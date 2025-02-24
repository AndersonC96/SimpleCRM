<?php
    namespace App\Controllers;
    class BaseController {
        /**
        * Renderiza a view correspondente.
        *
        * @param string $view Nome do arquivo de view (sem extensão)
        * @param array  $data Dados a serem passados para a view
        */
        protected function render($view, $data = []) {
            extract($data);
            require_once BASE_PATH . "/app/Views/{$view}.php";
        }
    }
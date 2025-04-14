<?php
    namespace App\Core;
    class Router {
        private array $routes = [];
        public function get(string $uri, string $action): void {
            $this->routes['GET'][$uri] = $action;
        }
        public function post(string $uri, string $action): void {
            $this->routes['POST'][$uri] = $action;
        }
        public function run(string $url): void {
            $method = $_SERVER['REQUEST_METHOD'];
            $action = $this->routes[$method][$url] ?? null;
            if ($action) {
                [$controller, $method] = explode('@', $action);
                $controllerClass = "App\\Controller\\$controller";
                if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
                    call_user_func([new $controllerClass, $method]);
                } else {
                    http_response_code(500);
                    echo "Erro interno: Controller ou método inválido.";
                }
            } else {
                http_response_code(404);
                echo "Página não encontrada.";
            }
        }
    }
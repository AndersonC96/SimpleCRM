<?php
    namespace App\Core;
    class Controller {
        public function middlewareAuth(): void {
            session_start();
            if (!isset($_SESSION['usuario'])) {
                header("Location: index.php?url=login");
                exit;
            }
        }
    }
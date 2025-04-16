<?php
    namespace App\Core;
    use PDO;
    use PDOException;
    class Database {
        /*public static function connect(): PDO {
                $host = $_ENV['DB_HOST'] ?? 'localhost';
            $dbname = $_ENV['DB_NAME'] ?? 'simplecrm';
            $user = $_ENV['DB_USER'] ?? 'root';
            $pass = $_ENV['DB_PASS'] ?? '';
            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco: " . $e->getMessage());
            }
        }*/
        private static ?PDO $instance = null;
        public static function getInstance(): PDO {
            if (self::$instance === null) {
                $host = $_ENV['DB_HOST'];
                $dbname = $_ENV['DB_NAME'];
                $user = $_ENV['DB_USER'];
                $pass = $_ENV['DB_PASS'];
                $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
                try {
                    self::$instance = new PDO($dsn, $user, $pass, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]);
                } catch (PDOException $e) {
                    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
                }
            }
            return self::$instance;
        }
    }
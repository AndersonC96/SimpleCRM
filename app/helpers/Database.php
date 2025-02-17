<?php
    /**
    * Classe Database
    *
    * Responsável por gerenciar a conexão com o banco de dados utilizando PDO.
    */
    class Database {
        /**
        * @var PDO|null Armazena a instância da conexão PDO.
        */
        private static $connection = null;
        /**
        * Retorna uma instância da conexão PDO com o banco de dados.
        *
        * @return PDO A conexão com o banco de dados.
        * @throws Exception Se os parâmetros de conexão forem inválidos ou se ocorrer um erro na conexão.
        */
        public static function getConnection() {
            if (self::$connection === null) {
                // Carrega as variáveis de ambiente utilizando a biblioteca vlucas/phpdotenv
                // Certifique-se de ter instalado a biblioteca via Composer:
                // composer require vlucas/phpdotenv
                $envPath = __DIR__ . '/../../';
                if (file_exists($envPath . '.env')) {
                    $dotenv = Dotenv\Dotenv::createImmutable($envPath);
                    $dotenv->load();
                } else {
                    throw new Exception("Arquivo .env não encontrado.");
                }
                // Recupera as configurações do banco de dados a partir das variáveis de ambiente
                $host     = $_ENV['DB_HOST'] ?? null;
                $dbname   = $_ENV['DB_NAME'] ?? null;
                $username = $_ENV['DB_USER'] ?? null;
                $password = $_ENV['DB_PASS'] ?? null;
                // Valida os parâmetros essenciais
                if (empty($host) || empty($dbname) || empty($username)) {
                    throw new Exception("Parâmetros de conexão inválidos. Verifique DB_HOST, DB_NAME e DB_USER no arquivo .env.");
                }
                // Cria a DSN (Data Source Name) com charset utf8mb4
                $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
                try {
                    self::$connection = new PDO($dsn, $username, $password);
                    // Configura o PDO para lançar exceções em caso de erro
                    self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // Define o modo de fetch padrão como FETCH_ASSOC para retornar arrays associativos
                    self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    // Em produção, é aconselhável logar o erro e exibir uma mensagem genérica para o usuário.
                    throw new Exception("Erro de conexão com o banco de dados: " . $e->getMessage());
                }
            }
            return self::$connection;
        }
    }
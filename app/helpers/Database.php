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
                // Configurações do banco de dados - ajuste conforme seu ambiente
                $host     = 'localhost';
                $dbname   = 'nome_do_banco';
                $username = 'usuario';
                $password = 'senha';
                // Valida os parâmetros essenciais
                if (empty($host) || empty($dbname) || empty($username)) {
                    throw new Exception("Parâmetros de conexão inválidos. Verifique host, dbname e username.");
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
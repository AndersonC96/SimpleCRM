<?php
    class Client {
        /**
         * Retorna todos os clientes cadastrados.
        *
        * @return array Array de clientes ou um array vazio em caso de falha.
        */
        public static function getAll() {
            try {
                $db = Database::getConnection();
                $stmt = $db->query("SELECT * FROM clients");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                // Log de erro ou tratamento adicional pode ser feito aqui.
                return [];
            }
        }
        /**
         * Cria um novo cliente.
        *
        * @param string $clientName Nome do cliente.
        * @param string $clientContact Contato do cliente.
        * @return bool Retorna true se o cliente for criado com sucesso, ou false em caso de erro.
        */
        public static function create($clientName, $clientContact) {
            // Valida os parâmetros obrigatórios
            if (empty($clientName) || empty($clientContact)) {
                return false;
            }
            // Sanitiza os dados
            $clientName    = filter_var(trim($clientName), FILTER_SANITIZE_STRING);
            $clientContact = filter_var(trim($clientContact), FILTER_SANITIZE_STRING);
            // Verifica se após sanitização os campos continuam válidos
            if (empty($clientName) || empty($clientContact)) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("INSERT INTO clients (name, contact) VALUES (:name, :contact)");
                return $stmt->execute([
                    ':name'    => $clientName,
                    ':contact' => $clientContact
                ]);
            } catch (Exception $e) {
                // Log de erro ou tratamento adicional pode ser feito aqui.
                return false;
            }
        }
        /**
         * Atualiza os dados de um cliente.
        *
        * @param int    $clientId      ID do cliente a ser atualizado.
        * @param string $clientName    Novo nome do cliente.
        * @param string $clientContact Novo contato do cliente.
        * @return bool Retorna true se atualizado com sucesso, false caso contrário.
        */
        public static function update($clientId, $clientName, $clientContact) {
            // Validação dos parâmetros
            if (empty($clientId) || intval($clientId) <= 0 || empty($clientName) || empty($clientContact)) {
                return false;
            }
            // Sanitiza os dados
            $clientName    = filter_var(trim($clientName), FILTER_SANITIZE_STRING);
            $clientContact = filter_var(trim($clientContact), FILTER_SANITIZE_STRING);
            if (empty($clientName) || empty($clientContact)) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("UPDATE clients SET name = :name, contact = :contact WHERE id = :id");
                return $stmt->execute([
                    ':name'    => $clientName,
                    ':contact' => $clientContact,
                    ':id'      => $clientId
                ]);
            } catch (Exception $e) {
                // Log de erro ou tratamento adicional pode ser feito aqui.
                return false;
            }
        }
        /**
         * Exclui um cliente.
        *
        * @param int $clientId ID do cliente a ser excluído.
        * @return bool Retorna true se excluído com sucesso, false em caso de erro.
        */
        public static function delete($clientId) {
            if (empty($clientId) || intval($clientId) <= 0) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("DELETE FROM clients WHERE id = :id");
                return $stmt->execute([':id' => $clientId]);
            } catch (Exception $e) {
                // Log de erro ou tratamento adicional pode ser feito aqui.
                return false;
            }
        }
        /**
         * Encontra um cliente pelo ID.
        *
        * @param int $clientId ID do cliente a ser buscado.
        * @return array|false Retorna um array associativo com os dados do cliente se encontrado, ou false se não encontrado.
        */
        public static function find($clientId) {
            if (empty($clientId) || intval($clientId) <= 0) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("SELECT * FROM clients WHERE id = :id LIMIT 1");
                $stmt->execute([':id' => $clientId]);
                $client = $stmt->fetch(PDO::FETCH_ASSOC);
                return $client ? $client : false;
            } catch (Exception $e) {
                // Log de erro ou tratamento adicional pode ser feito aqui.
                return false;
            }
        }
    }
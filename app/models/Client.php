<?php
    require_once __DIR__ . '/../helpers/Database.php';
    class Client {
        /**
        * Retorna todos os clientes cadastrados.
        *
        * @return array Array de clientes ou um array vazio em caso de erro.
        */
        public static function getAll() {
            try {
                $db = Database::getConnection();
                $stmt = $db->query("SELECT * FROM clients");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                return [];
            }
        }
        /**
        * Cria um novo cliente.
        *
        * @param string $clientName Nome do cliente.
        * @param string $clientContact Contato do cliente.
        * @return bool Retorna true se criado com sucesso, false em caso de erro.
        */
        public static function create($clientName, $clientContact) {
            if (empty($clientName) || empty($clientContact)) {
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
                $stmt = $db->prepare("INSERT INTO clients (name, contact, created_at) VALUES (:name, :contact, NOW())");
                return $stmt->execute([
                    ':name' => $clientName,
                    ':contact' => $clientContact
                ]);
            } catch (Exception $e) {
                return false;
            }
        }
        /**
        * Atualiza os dados de um cliente.
        *
        * @param int $clientId
        * @param string $clientName
        * @param string $clientContact
        * @return bool
        */
        public static function update($clientId, $clientName, $clientContact) {
            if (empty($clientId) || intval($clientId) <= 0 || empty($clientName) || empty($clientContact)) {
                return false;
            }
            $clientName    = filter_var(trim($clientName), FILTER_SANITIZE_STRING);
            $clientContact = filter_var(trim($clientContact), FILTER_SANITIZE_STRING);
            if (empty($clientName) || empty($clientContact)) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("UPDATE clients SET name = :name, contact = :contact, updated_at = NOW() WHERE id = :id");
                return $stmt->execute([
                    ':name' => $clientName,
                    ':contact' => $clientContact,
                    ':id' => $clientId
                ]);
            } catch (Exception $e) {
                return false;
            }
        }
        /**
        * Exclui um cliente.
        *
        * @param int $clientId
        * @return bool
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
                return false;
            }
        }
        /**
        * Encontra um cliente pelo ID.
        *
        * @param int $clientId
        * @return array|false
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
                return false;
            }
        }
    }
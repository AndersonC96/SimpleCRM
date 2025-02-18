<?php
    require_once __DIR__ . '/../helpers/Database.php';
    class Form {
        /**
        * Retorna todos os formulários do usuário.
        *
        * @param int $userId
        * @return array
        */
        public static function getAllByUser($userId) {
            if (empty($userId) || intval($userId) <= 0) {
                return [];
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("SELECT * FROM forms WHERE user_id = :user_id");
                $stmt->execute([':user_id' => $userId]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                return [];
            }
        }
        /**
        * Cria um novo formulário.
        *
        * @param int $userId
        * @param string $name
        * @param string $content
        * @return bool|mixed Retorna o ID do formulário criado ou false.
        */
        public static function create($userId, $name, $content) {
            if (empty($userId) || empty($name) || empty($content)) {
                return false;
            }
            $name = filter_var(trim($name), FILTER_SANITIZE_STRING);
            $content = filter_var(trim($content), FILTER_SANITIZE_STRING);
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("INSERT INTO forms (user_id, name, content, created_at) VALUES (:user_id, :name, :content, NOW())");
                if ($stmt->execute([
                    ':user_id' => $userId,
                    ':name'    => $name,
                    ':content' => $content
                ])) {
                    return $db->lastInsertId();
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
        }
        /**
        * Atualiza um formulário existente.
        *
        * @param int $formId
        * @param int $userId
        * @param string $name
        * @param string $content
        * @return bool
        */
        public static function update($formId, $userId, $name, $content) {
            if (empty($formId) || intval($formId) <= 0 || empty($userId) || empty($name) || empty($content)) {
                return false;
            }
            $name = filter_var(trim($name), FILTER_SANITIZE_STRING);
            $content = filter_var(trim($content), FILTER_SANITIZE_STRING);
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("UPDATE forms SET name = :name, content = :content, updated_at = NOW() WHERE id = :id AND user_id = :user_id");
                return $stmt->execute([
                    ':name' => $name,
                    ':content' => $content,
                    ':id' => $formId,
                    ':user_id' => $userId
                ]);
            } catch (Exception $e) {
                return false;
            }
        }
        /**
        * Exclui um formulário.
        *
        * @param int $formId
        * @param int $userId
        * @return bool
        */
        public static function delete($formId, $userId) {
            if (empty($formId) || intval($formId) <= 0 || empty($userId)) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("DELETE FROM forms WHERE id = :id AND user_id = :user_id");
                return $stmt->execute([
                    ':id' => $formId,
                    ':user_id' => $userId
                ]);
            } catch (Exception $e) {
                return false;
            }
        }
        /**
        * Encontra um formulário pelo ID, pertencente ao usuário.
        *
        * @param int $formId
        * @param int $userId
        * @return array|false
        */
        public static function find($formId, $userId) {
            if (empty($formId) || intval($formId) <= 0 || empty($userId)) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("SELECT * FROM forms WHERE id = :id AND user_id = :user_id LIMIT 1");
                $stmt->execute([
                    ':id' => $formId,
                    ':user_id' => $userId
                ]);
                $form = $stmt->fetch(PDO::FETCH_ASSOC);
                return $form ? $form : false;
            } catch (Exception $e) {
                return false;
            }
        }
    }
<?php
    class User {
        /**
         * Autentica o usuário com base no username e senha.
        * Retorna os dados do usuário (array associativo) se autenticado ou false em caso de falha.
        */
        public static function authenticate($username, $password) {
            // Validação básica dos parâmetros
            if (empty($username) || empty($password)) {
                return false;
            }
            // Obtém a conexão com o banco de dados
            $db = Database::getConnection();
            // Prepara a consulta para evitar injeção de SQL
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verifica se o usuário existe e se a senha informada confere com o hash armazenado
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        }
        /**
         * Cria um novo usuário.
        * Retorna o ID do usuário criado ou false em caso de erro.
        */
        public static function create($username, $email, $passwordHash) {
            // Validação dos parâmetros
            if (empty($username) || empty($email) || empty($passwordHash)) {
                return false;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            // Verifica se o usuário já existe
            if (self::exists($username)) {
                return false;
            }
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return $db->lastInsertId();
            }
            return false;
        }
        /**
         * Atualiza os dados do usuário.
        * Se $passwordHash for null, a senha não será alterada.
        * Retorna true se atualizado com sucesso, false caso contrário.
        */
        public static function update($userId, $username, $email, $passwordHash = null) {
            // Validação dos parâmetros
            if (empty($userId) || empty($username) || empty($email)) {
                return false;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            $db = Database::getConnection();
            if ($passwordHash !== null) {
                $stmt = $db->prepare("UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id");
                $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
            } else {
                $stmt = $db->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
            }
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        }
        /**
         * Exclui o usuário identificado por $userId.
        * Retorna true em caso de sucesso ou false se ocorrer erro.
        */
        public static function delete($userId) {
            if (empty($userId) || intval($userId) <= 0) {
                return false;
            }
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        }
        /**
         * Verifica se um usuário com o mesmo username já existe.
        * Retorna true se existir, false caso contrário.
        */
        public static function exists($username) {
            if (empty($username)) {
                return false;
            }
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }
        /**
         * Busca um usuário pelo email.
        * Retorna os dados do usuário (array associativo) ou false se não encontrado.
        */
        public static function findByEmail($email) {
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ? $user : false;
        }
        /**
         * Armazena um token de recuperação para o usuário.
        * Retorna true se atualizado com sucesso, false caso contrário.
        */
        public static function storeResetToken($userId, $token) {
            if (empty($userId) || empty($token)) {
                return false;
            }
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE users SET reset_token = :token, token_created_at = NOW() WHERE id = :id");
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
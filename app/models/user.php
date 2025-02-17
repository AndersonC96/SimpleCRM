<?php
    // Inclui a classe Database para garantir que a conexão seja possível
    require_once __DIR__ . '/../helpers/Database.php';
    class User {
        public static function authenticate($username, $password) {
            if (empty($username) || empty($password)) {
                return false;
            }
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        }
        public static function create($username, $email, $passwordHash) {
            if (empty($username) || empty($email) || empty($passwordHash)) {
                return false;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
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
        public static function update($userId, $username, $email, $passwordHash = null) {
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
        public static function delete($userId) {
            if (empty($userId) || intval($userId) <= 0) {
                return false;
            }
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        }
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
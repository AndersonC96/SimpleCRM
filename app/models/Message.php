<?php
    class Message {
        /**
         * Retorna os status de envio das mensagens.
        *
        * Este método consulta o banco de dados para agrupar os registros da tabela
        * "messages" de acordo com o status (por exemplo, "sent", "delivered", "failed", etc.).
        *
        * @return array Retorna um array de status com suas respectivas contagens ou um array vazio se nenhum registro for encontrado.
        */
        public static function getStatuses() {
            try {
                $db = Database::getConnection();
                $stmt = $db->query("SELECT status, COUNT(*) as total FROM messages GROUP BY status");
                $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // Se não houver registros, retorna um array vazio
                return $statuses ? $statuses : [];
            } catch (Exception $e) {
                // Aqui você pode logar o erro, se necessário.
                return [];
            }
        }
        /**
         * Salva as informações sobre o envio de uma mensagem.
        *
        * Este método registra no banco de dados o número de telefone do destinatário,
        * o conteúdo da mensagem e o status do envio, juntamente com a data/hora do registro.
        *
        * @param string $phone   Número de telefone do destinatário.
        * @param string $message Conteúdo da mensagem.
        * @param string $status  Status de envio (ex.: "sent", "delivered", "failed", etc.).
        * @return bool Retorna true se a operação for bem-sucedida, ou false em caso de erro ou dados inválidos.
        */
        public static function saveStatus($phone, $message, $status) {
            // Validação e sanitização dos parâmetros obrigatórios
            if (empty($phone) || empty($message) || empty($status)) {
                return false;
            }
            $phone   = filter_var(trim($phone), FILTER_SANITIZE_STRING);
            $message = filter_var(trim($message), FILTER_SANITIZE_STRING);
            $status  = filter_var(trim($status), FILTER_SANITIZE_STRING);
            // Verifica se os dados sanitizados não ficaram vazios
            if (empty($phone) || empty($message) || empty($status)) {
                return false;
            }
            // Validação opcional: formato do número de telefone (aceitando opcionalmente '+' seguido de 7 a 15 dígitos)
            if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
                return false;
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("INSERT INTO messages (phone, message, status, created_at) VALUES (:phone, :message, :status, NOW())");
                return $stmt->execute([
                    ':phone'   => $phone,
                    ':message' => $message,
                    ':status'  => $status
                ]);
            } catch (Exception $e) {
                // Aqui você pode logar o erro, se necessário.
                return false;
            }
        }
    }
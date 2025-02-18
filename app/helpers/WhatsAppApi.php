<?php
    class WhatsAppApi {
        // As credenciais serão carregadas do .env
        private static $apiUrl;
        private static $apiKey;
        /**
        * Inicializa as configurações da API a partir das variáveis de ambiente.
        * Lança uma exceção se as variáveis essenciais não estiverem definidas.
        */
        private static function init() {
            if (isset(self::$apiUrl) && isset(self::$apiKey)) {
                return;
            }
            if (!isset($_ENV['WHATSAPP_API_URL']) || !isset($_ENV['WHATSAPP_API_KEY'])) {
                throw new Exception("Credenciais da API do WhatsApp não definidas no .env.");
            }
            self::$apiUrl = $_ENV['WHATSAPP_API_URL'];
            self::$apiKey = $_ENV['WHATSAPP_API_KEY'];
        }
        /**
        * Envia uma mensagem imediatamente via API do WhatsApp.
        *
        * @param string $phone   Número de telefone do destinatário.
        * @param string $message Conteúdo da mensagem.
        * @return bool           Retorna true se a mensagem for enviada com sucesso.
        * @throws Exception      Se os parâmetros forem inválidos ou ocorrer erro na requisição.
        */
        public static function sendMessage($phone, $message) {
            self::init();
            // Validação dos parâmetros
            if (empty($phone) || empty($message)) {
                throw new Exception("Telefone e mensagem são obrigatórios.");
            }
            // Sanitiza os parâmetros
            $phone   = filter_var(trim($phone), FILTER_SANITIZE_STRING);
            $message = filter_var(trim($message), FILTER_SANITIZE_STRING);
            if (empty($phone) || empty($message)) {
                throw new Exception("Telefone ou mensagem ficaram vazios após sanitização.");
            }
            // Valida o formato do telefone: aceita opcionalmente '+' seguido de 7 a 15 dígitos
            if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
                throw new Exception("Formato de telefone inválido. Deve conter entre 7 e 15 dígitos, opcionalmente com '+' no início.");
            }
            // Monta os dados para a requisição
            $data = [
                'api_key' => self::$apiKey,
                'phone'   => $phone,
                'message' => $message
            ];
            // Inicializa o cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::$apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                throw new Exception("Erro no envio: " . curl_error($ch));
            }
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return ($httpCode == 200);
        }
        /**
        * Agenda o envio de uma mensagem via API do WhatsApp.
        *
        * @param string $phone            Número de telefone do destinatário.
        * @param string $message          Conteúdo da mensagem.
        * @param string $scheduleDatetime Data e hora para envio (formato: "YYYY-MM-DD HH:MM:SS").
        * @return bool                    Retorna true se o agendamento for realizado com sucesso.
        * @throws Exception               Se os parâmetros forem inválidos ou ocorrer erro na requisição.
        */
        public static function scheduleMessage($phone, $message, $scheduleDatetime) {
            self::init();
            if (empty($phone) || empty($message) || empty($scheduleDatetime)) {
                throw new Exception("Telefone, mensagem e data/hora de agendamento são obrigatórios.");
            }
            $phone            = filter_var(trim($phone), FILTER_SANITIZE_STRING);
            $message          = filter_var(trim($message), FILTER_SANITIZE_STRING);
            $scheduleDatetime = filter_var(trim($scheduleDatetime), FILTER_SANITIZE_STRING);
            if (empty($phone) || empty($message) || empty($scheduleDatetime)) {
                throw new Exception("Parâmetros não podem ficar vazios após sanitização.");
            }
            if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
                throw new Exception("Formato de telefone inválido. Deve conter entre 7 e 15 dígitos, opcionalmente com '+' no início.");
            }
            $d = DateTime::createFromFormat('Y-m-d H:i:s', $scheduleDatetime);
            if (!$d || $d->format('Y-m-d H:i:s') !== $scheduleDatetime) {
                throw new Exception("Formato de data/hora inválido. Use 'YYYY-MM-DD HH:MM:SS'.");
            }
            // Define o endpoint para agendamento; ajusta conforme a documentação da API
            $apiUrl = self::$apiUrl . '/schedule';
            $data = [
                'api_key'           => self::$apiKey,
                'phone'             => $phone,
                'message'           => $message,
                'schedule_datetime' => $scheduleDatetime
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                throw new Exception("Erro no agendamento: " . curl_error($ch));
            }
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return ($httpCode == 200);
        }
        /**
        * Atualiza ou registra o status de entrega de uma mensagem.
        * Esse método pode ser usado para registrar feedback da API, como "sent", "delivered", "read" ou "error".
        *
        * @param int    $messageId ID da mensagem no sistema.
        * @param string $status    Novo status da mensagem.
        * @return bool             Retorna true se a atualização for bem-sucedida, false caso contrário.
        * @throws Exception        Se os parâmetros forem inválidos.
        */
        public static function updateMessageStatus($messageId, $status) {
            if (empty($messageId) || empty($status)) {
                throw new Exception("ID da mensagem e status são obrigatórios.");
            }
            require_once __DIR__ . '/../helpers/Database.php';
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE messages SET status = :status WHERE id = :id");
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':id', $messageId, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
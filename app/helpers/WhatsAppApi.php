<?php
    class WhatsAppApi {
        // As credenciais serão lidas do arquivo .env
        private static $apiUrl;
        private static $apiKey;
        /**
        * Inicializa as configurações da API a partir do arquivo .env.
        * Esse método é chamado automaticamente na primeira utilização.
        */
        private static function init() {
            // Se as variáveis já estiverem definidas, não faz nada.
            if (isset(self::$apiUrl) && isset(self::$apiKey)) {
                return;
            }
            // Carrega as variáveis de ambiente, se necessário.
            // Aqui assumimos que o carregamento do .env já foi feito em algum lugar
            // no início da aplicação, como no front controller (index.php),
            // ou podemos carregá-lo aqui também.
            if (!isset($_ENV['WHATSAPP_API_URL']) || !isset($_ENV['WHATSAPP_API_KEY'])) {
                throw new Exception("Credenciais da API do WhatsApp não encontradas. Verifique o arquivo .env.");
            }
            self::$apiUrl = $_ENV['WHATSAPP_API_URL'];
            self::$apiKey = $_ENV['WHATSAPP_API_KEY'];
        }
        /**
        * Envia uma mensagem imediatamente via API do WhatsApp.
        *
        * @param string $phone   Número de telefone do destinatário.
        * @param string $message Conteúdo da mensagem.
        * @return bool           Retorna true se a mensagem for enviada com sucesso, false caso contrário.
        * @throws Exception      Se os parâmetros forem inválidos ou ocorrer erro na requisição.
        */
        public static function sendMessage($phone, $message) {
            // Inicializa as configurações da API
            self::init();
            // Validação dos parâmetros
            if (empty($phone) || empty($message)) {
                throw new Exception("Parâmetros inválidos: telefone e mensagem são obrigatórios.");
            }
            // Sanitiza os parâmetros
            $phone   = filter_var(trim($phone), FILTER_SANITIZE_STRING);
            $message = filter_var(trim($message), FILTER_SANITIZE_STRING);
            if (empty($phone) || empty($message)) {
                throw new Exception("Telefone ou mensagem ficaram vazios após sanitização.");
            }
            // Valida o formato do telefone (aceita opcionalmente '+' e de 7 a 15 dígitos)
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
            // Verifica se ocorreu algum erro na requisição cURL
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
        * @param string $phone             Número de telefone do destinatário.
        * @param string $message           Conteúdo da mensagem.
        * @param string $scheduleDatetime  Data e hora para envio no formato "YYYY-MM-DD HH:MM:SS".
        * @return bool                     Retorna true se o agendamento for realizado com sucesso, false caso contrário.
        * @throws Exception              Se os parâmetros forem inválidos ou ocorrer erro na requisição.
        */
        public static function scheduleMessage($phone, $message, $scheduleDatetime) {
            // Inicializa as configurações da API
            self::init();
            // Validação dos parâmetros
            if (empty($phone) || empty($message) || empty($scheduleDatetime)) {
                throw new Exception("Parâmetros inválidos: telefone, mensagem e data/hora de agendamento são obrigatórios.");
            }
            // Sanitiza os parâmetros
            $phone            = filter_var(trim($phone), FILTER_SANITIZE_STRING);
            $message          = filter_var(trim($message), FILTER_SANITIZE_STRING);
            $scheduleDatetime = filter_var(trim($scheduleDatetime), FILTER_SANITIZE_STRING);
            if (empty($phone) || empty($message) || empty($scheduleDatetime)) {
                throw new Exception("Os parâmetros não podem ficar vazios após sanitização.");
            }
            // Valida o formato do telefone
            if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
                throw new Exception("Formato de telefone inválido. Deve conter entre 7 e 15 dígitos, opcionalmente com '+' no início.");
            }
            // Valida o formato da data e hora
            $d = DateTime::createFromFormat('Y-m-d H:i:s', $scheduleDatetime);
            if (!$d || $d->format('Y-m-d H:i:s') !== $scheduleDatetime) {
                throw new Exception("Formato de data/hora inválido. Use o formato 'YYYY-MM-DD HH:MM:SS'.");
            }
            // Define o endpoint para agendamento (ajuste conforme necessário)
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
    }
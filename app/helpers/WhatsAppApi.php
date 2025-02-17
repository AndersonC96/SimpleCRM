<?php
    class WhatsAppApi {
        // URL base da API do WhatsApp (exemplo fictício)
        private static $apiUrl = 'https://api.whatsapp.com/sendMessage';
        // Chave da API (substitua pela sua chave real)
        private static $apiKey = 'sua_api_key';
        /**
        * Envia uma mensagem imediatamente via API do WhatsApp.
        *
        * @param string $phone   Número de telefone do destinatário.
        * @param string $message Conteúdo da mensagem.
        * @return bool           Retorna true se a mensagem for enviada com sucesso, false caso contrário.
        * @throws Exception      Se os parâmetros forem inválidos ou ocorrer erro na requisição.
        */
        public static function sendMessage($phone, $message) {
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
            // Valida o formato do telefone (opcionalmente iniciando com '+' e contendo de 7 a 15 dígitos)
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
            // Obtém o código HTTP da resposta
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            // Retorna true se a resposta HTTP for 200 (OK)
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
            // Define o endpoint para agendamento (ajuste conforme sua API)
            $apiUrl = self::$apiUrl . '/schedule';
            // Monta os dados para a requisição
            $data = [
                'api_key'           => self::$apiKey,
                'phone'             => $phone,
                'message'           => $message,
                'schedule_datetime' => $scheduleDatetime
            ];
            // Inicializa o cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            // Verifica se ocorreu algum erro na requisição cURL
            if (curl_errno($ch)) {
                throw new Exception("Erro no agendamento: " . curl_error($ch));
            }
            // Obtém o código HTTP da resposta
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            // Retorna true se a resposta HTTP for 200 (OK)
            return ($httpCode == 200);
        }
    }
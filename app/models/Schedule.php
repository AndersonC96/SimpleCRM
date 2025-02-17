<?php
    class Schedule {
        /**
        * Salva um agendamento de envio de mensagem.
        *
        * @param int    $userId        ID do usuário que está agendando a mensagem.
        * @param string $scheduleDate  Data do agendamento (formato: YYYY-MM-DD).
        * @param string $scheduleTime  Horário do agendamento (formato: HH:MM ou HH:MM:SS).
        * @param string $message       Conteúdo da mensagem a ser agendada.
        * @return bool                 Retorna true se o agendamento for salvo com sucesso, ou false em caso de erro.
        */
        public static function create($userId, $scheduleDate, $scheduleTime, $message) {
            // Validação do ID do usuário
            if (empty($userId) || intval($userId) <= 0) {
                return false;
            }
            // Validação da data
            if (empty($scheduleDate) || !self::validateDate($scheduleDate)) {
                return false;
            }
            // Validação do horário
            if (empty($scheduleTime) || !self::validateTime($scheduleTime)) {
                return false;
            }
            // Validação da mensagem
            if (empty($message)) {
                return false;
            }
            // Sanitiza os dados
            $scheduleDate = filter_var(trim($scheduleDate), FILTER_SANITIZE_STRING);
            $scheduleTime = filter_var(trim($scheduleTime), FILTER_SANITIZE_STRING);
            $message      = filter_var(trim($message), FILTER_SANITIZE_STRING);
            // Se o horário foi informado no formato HH:MM, adiciona ":00" para completar o formato HH:MM:SS
            if (strlen($scheduleTime) == 5) {
                $scheduleTime .= ':00';
            }
            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("INSERT INTO schedules (user_id, schedule_date, schedule_time, message, created_at) VALUES (:user_id, :schedule_date, :schedule_time, :message, NOW())");
                return $stmt->execute([
                    ':user_id'       => $userId,
                    ':schedule_date' => $scheduleDate,
                    ':schedule_time' => $scheduleTime,
                    ':message'       => $message
                ]);
            } catch (Exception $e) {
                // Opcional: log o erro para análise
                return false;
            }
        }
        /**
        * Valida se a data está no formato YYYY-MM-DD.
        *
        * @param string $date Data a ser validada.
        * @return bool        Retorna true se a data for válida, false caso contrário.
        */
        private static function validateDate($date) {
            $d = DateTime::createFromFormat('Y-m-d', $date);
            return ($d && $d->format('Y-m-d') === $date);
        }
        /**
        * Valida se o horário está no formato HH:MM ou HH:MM:SS.
        *
        * @param string $time Horário a ser validado.
        * @return bool        Retorna true se o horário for válido, false caso contrário.
        */
        private static function validateTime($time) {
            // Tenta validar no formato HH:MM:SS
            $t = DateTime::createFromFormat('H:i:s', $time);
            if ($t && $t->format('H:i:s') === $time) {
                return true;
            }
            // Se não, tenta validar no formato HH:MM
            $t = DateTime::createFromFormat('H:i', $time);
            return ($t && $t->format('H:i') === $time);
        }
    }
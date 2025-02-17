<?php
    class MessageController {
        /**
         * Envia imediatamente uma mensagem via API do WhatsApp.
        */
        public function send() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtém e sanitiza os dados do formulário
                $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
                $message = isset($_POST['message']) ? trim($_POST['message']) : '';
                $errors  = [];
                // Validação do número de telefone (aceita opcionalmente o sinal '+' e de 7 a 15 dígitos)
                if (empty($phone)) {
                    $errors[] = "O número de telefone é obrigatório.";
                } elseif (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
                    $errors[] = "Formato de número de telefone inválido.";
                }
                // Validação do conteúdo da mensagem
                if (empty($message)) {
                    $errors[] = "A mensagem é obrigatória.";
                }
                // Se houver erros, armazena-os na sessão e redireciona de volta para o formulário
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=message/send");
                    exit;
                }
                // Inclui o helper para integração com a API do WhatsApp
                require_once 'app/helpers/WhatsAppApi.php';
                // Tenta enviar a mensagem imediatamente
                try {
                    // O método sendMessage deve retornar true em caso de sucesso ou lançar uma exceção em caso de erro
                    $result = WhatsAppApi::sendMessage($phone, $message);
                    if ($result === true) {
                        $_SESSION['success_message'] = "Mensagem enviada com sucesso.";
                    } else {
                        $_SESSION['errors'][] = "Falha ao enviar a mensagem.";
                    }
                } catch (Exception $e) {
                    $_SESSION['errors'][] = "Erro ao enviar a mensagem: " . $e->getMessage();
                }
                header("Location: index.php?url=message/send");
                exit;
            }
            // Exibe a view de envio de mensagem
            require 'app/views/message/send.php';
        }
        /**
         * Agenda o envio de uma mensagem via API do WhatsApp.
        */
        public function schedule() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtém e sanitiza os dados do formulário
                $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
                $message = isset($_POST['message']) ? trim($_POST['message']) : '';
                $scheduleDate = isset($_POST['schedule_date']) ? trim($_POST['schedule_date']) : '';
                $scheduleTime = isset($_POST['schedule_time']) ? trim($_POST['schedule_time']) : '';
                $errors = [];
                // Validação do número de telefone
                if (empty($phone)) {
                    $errors[] = "O número de telefone é obrigatório.";
                } elseif (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
                    $errors[] = "Formato de número de telefone inválido.";
                }
                // Validação do conteúdo da mensagem
                if (empty($message)) {
                    $errors[] = "A mensagem é obrigatória.";
                }
                // Validação da data de agendamento (formato esperado: YYYY-MM-DD)
                if (empty($scheduleDate)) {
                    $errors[] = "A data de agendamento é obrigatória.";
                } else {
                    $d = DateTime::createFromFormat('Y-m-d', $scheduleDate);
                    if (!($d && $d->format('Y-m-d') === $scheduleDate)) {
                        $errors[] = "Data de agendamento inválida. Formato esperado: YYYY-MM-DD.";
                    }
                }
                // Validação do horário de agendamento (formato esperado: HH:MM em 24h)
                if (empty($scheduleTime)) {
                    $errors[] = "O horário de agendamento é obrigatório.";
                } else {
                    $t = DateTime::createFromFormat('H:i', $scheduleTime);
                    if (!($t && $t->format('H:i') === $scheduleTime)) {
                        $errors[] = "Horário de agendamento inválido. Formato esperado: HH:MM (24h).";
                    }
                }
                // Se houver erros, armazena-os na sessão e redireciona
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header("Location: index.php?url=message/schedule");
                    exit;
                }
                // Combina data e horário para formar um datetime completo
                $scheduleDatetime = $scheduleDate . ' ' . $scheduleTime . ':00'; // Formato: YYYY-MM-DD HH:MM:SS
                // Inclui o helper para integração com a API do WhatsApp
                require_once 'app/helpers/WhatsAppApi.php';
                // Tenta agendar o envio da mensagem
                try {
                    // O método scheduleMessage deve retornar true em caso de sucesso ou lançar uma exceção em caso de erro
                    $result = WhatsAppApi::scheduleMessage($phone, $message, $scheduleDatetime);
                    if ($result === true) {
                        $_SESSION['success_message'] = "Mensagem agendada com sucesso.";
                    } else {
                        $_SESSION['errors'][] = "Falha ao agendar a mensagem.";
                    }
                } catch (Exception $e) {
                    $_SESSION['errors'][] = "Erro ao agendar a mensagem: " . $e->getMessage();
                }
                header("Location: index.php?url=message/schedule");
                exit;
            }
            // Exibe a view de agendamento de mensagem
            require 'app/views/message/schedule.php';
        }
        /**
         * Exibe o status de envio das mensagens (enviado, entregue, etc.).
        */
        public function status() {
            // Inicia a sessão, se necessário
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // Inclui o modelo de Message para buscar os status das mensagens
            require_once 'app/models/Message.php';
            try {
                // Busca os status das mensagens utilizando o método getStatuses()
                // O método getStatuses() deve retornar um array com os status (ex.: enviados, entregues, lidos, etc.)
                $statuses = Message::getStatuses();
            } catch (Exception $e) {
                // Em caso de erro, armazena a mensagem de erro na sessão e define $statuses como um array vazio
                $_SESSION['errors'][] = "Erro ao buscar status das mensagens: " . $e->getMessage();
                $statuses = [];
            }
            // Agora, a variável $statuses estará disponível na view para exibição dos status das mensagens
            require 'app/views/message/status.php';
        }
    }
<?php
    // Carrega o autoload do Composer para o PHPMailer e demais dependências
    require_once __DIR__ . '/../../vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    class Mailer {
        /**
        * Envia um e-mail utilizando PHPMailer.
        *
        * @param string $to      Endereço de e-mail do destinatário.
        * @param string $subject Assunto do e-mail.
        * @param string $body    Corpo do e-mail (pode ser HTML).
        * @return bool           Retorna true se o e-mail for enviado com sucesso, ou false em caso de erro.
        * @throws Exception      Caso ocorra um erro crítico durante a configuração.
        */
        public static function sendEmail($to, $subject, $body) {
            // Valida os parâmetros
            if (empty($to) || empty($subject) || empty($body)) {
                throw new Exception("Parâmetros 'to', 'subject' e 'body' são obrigatórios.");
            }
            if (!filter_var(trim($to), FILTER_VALIDATE_EMAIL)) {
                throw new Exception("O endereço de e-mail do destinatário é inválido.");
            }
            // Recupera as configurações do e-mail a partir do .env ou constantes definidas em config.php
            $mailHost = $_ENV['MAIL_HOST'] ?? null;
            $mailUsername = $_ENV['MAIL_USERNAME'] ?? null;
            $mailPassword = $_ENV['MAIL_PASSWORD'] ?? null;
            $mailPort = $_ENV['MAIL_PORT'] ?? 587;
            $mailFrom = $_ENV['MAIL_FROM'] ?? null;
            $mailFromName = $_ENV['MAIL_FROM_NAME'] ?? 'SimpleCRM';
            if (empty($mailHost) || empty($mailUsername) || empty($mailPassword) || empty($mailFrom)) {
                throw new Exception("Configurações de e-mail não estão definidas corretamente no .env.");
            }
            // Cria uma instância do PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Configuração do servidor SMTP
                $mail->isSMTP();
                $mail->Host       = $mailHost;
                $mail->SMTPAuth   = true;
                $mail->Username   = $mailUsername;
                $mail->Password   = $mailPassword;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = $mailPort;
                // Configura o remetente e o destinatário
                $mail->setFrom($mailFrom, $mailFromName);
                $mail->addAddress(trim($to));
                // Define o formato do e-mail para HTML
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $body;
                // Envia o e-mail
                $mail->send();
                return true;
            } catch (Exception $e) {
                // Você pode logar o erro ($mail->ErrorInfo) se necessário
                return false;
            }
        }
    }
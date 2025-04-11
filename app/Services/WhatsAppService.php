<?php
    namespace Tisim\SimpleCrm\Services;
    use GuzzleHttp\Client;
    class WhatsAppService {
        protected string $accountSid;
        protected string $authToken;
        protected string $from;
        public function __construct() {
            $this->accountSid = $_ENV['TWILIO_SID'];
            $this->authToken  = $_ENV['TWILIO_TOKEN'];
            $this->from       = $_ENV['TWILIO_FROM'];
        }
        public function sendMessage(string $to, string $message): bool {
            $client = new Client();
            try {
                $response = $client->post("https://api.twilio.com/2010-04-01/Accounts/{$this->accountSid}/Messages.json", [
                    'auth' => [$this->accountSid, $this->authToken],
                    'form_params' => [
                        'From' => "whatsapp:{$this->from}",
                        'To'   => "whatsapp:{$to}",
                        'Body' => $message
                    ]
                ]);
                return $response->getStatusCode() === 201;
            } catch (\Exception $e) {
                // Pode logar em storage/logs/whatsapp.log futuramente
                return false;
            }
        }
    }
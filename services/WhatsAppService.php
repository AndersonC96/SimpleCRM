<?php
    namespace App\Service;
    use GuzzleHttp\Client;
    class WhatsAppService {
        private Client $client;
        private string $token;
        private string $apiUrl;
        public function __construct() {
            $this->token = $_ENV['WHATSAPP_TOKEN'] ?? '';
            $this->apiUrl = $_ENV['WHATSAPP_URL'] ?? 'https://graph.facebook.com/v18.0';
            $this->client = new Client([
                'base_uri' => $this->apiUrl,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/json'
                ]
            ]);
        }
        public function enviarMensagem(string $numero, string $mensagem): array {
            try {
                $payload = [
                    'messaging_product' => 'whatsapp',
                    'to' => $numero,
                    'type' => 'text',
                    'text' => ['body' => $mensagem]
                ];
                $response = $this->client->post('/me/messages', [
                    'json' => $payload
                ]);
                    return [
                    'success' => true,
                    'data' => json_decode($response->getBody(), true)
                ];
            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'error' => $e->getMessage()
                ];
            }
        }
    }
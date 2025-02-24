<?php
    namespace App\Controllers;
    use GuzzleHttp\Client;
    class WhatsAppController extends BaseController {
        /**
        * Envia uma mensagem via WhatsApp utilizando a API (ou serviço integrado).
        */
        public function sendMessage() {
            $data    = $_POST;
            $phone   = $data['phone'] ?? '';
            $message = $data['message'] ?? '';
            // Validação simples dos dados pode ser feita aqui
            $client = new Client();
            try {
                $response = $client->post('https://api.whatsapp.com/send', [
                    'json' => [
                        'phone'   => $phone,
                        'message' => $message
                    ]
                ]);
                $result = json_decode($response->getBody(), true);
                $this->render('whatsapp/success', ['result' => $result]);
            } catch (\Exception $e) {
                $error = $e->getMessage();
                $this->render('whatsapp/error', ['error' => $error]);
            }
        }
    }
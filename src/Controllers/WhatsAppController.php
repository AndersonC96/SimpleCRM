<?php

    class WhatsAppController
    {
        public function sendInvite($phone, $message) {
            require_once 'services/WhatsAppService.php';
            $whatsApp = new WhatsAppService();
            return $whatsApp->sendMessage($phone, $message);
        }
    }

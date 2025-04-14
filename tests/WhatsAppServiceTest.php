<?php
    use PHPUnit\Framework\TestCase;
    use App\Service\WhatsAppService;
    class WhatsAppServiceTest extends TestCase {
        public function testEnvioDeMensagemFalhaSemNumero() {
            $ws = new WhatsAppService();
            $resposta = $ws->enviarMensagem('', 'Olá');
            $this->assertFalse($resposta['success']);
        }
    }
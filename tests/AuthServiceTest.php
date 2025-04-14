<?php
    use PHPUnit\Framework\TestCase;
    use App\Service\AuthService;
    class AuthServiceTest extends TestCase {
        public function testLoginComCredenciaisInvalidasRetornaNull() {
            $resultado = AuthService::login('naoexiste@email.com', 'senhaerrada');
            $this->assertNull($resultado);
        }
    }
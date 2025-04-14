<?php
    use PHPUnit\Framework\TestCase;
    use App\Repository\ClienteRepository;
    class ClienteRepositoryTest extends TestCase {
        public function testListarTodosRetornaArray() {
            $repo = new ClienteRepository();
            $clientes = $repo->listarTodos();
            $this->assertIsArray($clientes);
        }
    }
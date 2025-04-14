<?php
    namespace App\Service;
    use Monolog\Logger;
    use Monolog\Handler\RotatingFileHandler;
    class LogService {
        private Logger $logger;
        public function __construct(string $canal = 'sistema', string $arquivo = 'system') {
            $this->logger = new Logger($canal);
            $caminho = __DIR__ . "/../logs/" . $arquivo;
            // Cria logs com rotação diária e mantém os últimos 30 dias
            $this->logger->pushHandler(new RotatingFileHandler($caminho, 30, Logger::DEBUG));
        }
        public function info(string $mensagem, array $context = []): void {
            $this->logger->info($mensagem, $context);
        }
        public function warning(string $mensagem, array $context = []): void {
            $this->logger->warning($mensagem, $context);
        }
        public function error(string $mensagem, array $context = []): void {
            $this->logger->error($mensagem, $context);
        }
    }
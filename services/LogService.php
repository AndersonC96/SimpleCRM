<?php
    namespace App\Service;
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    class LogService {
        private Logger $logger;
        public function __construct(string $canal = 'sistema', string $arquivo = 'system.log') {
            $this->logger = new Logger($canal);
            $caminho = __DIR__ . "/../logs/$arquivo";
            if (!is_dir(dirname($caminho))) {
                mkdir(dirname($caminho), 0777, true);
            }
            $this->logger->pushHandler(new StreamHandler($caminho, Logger::DEBUG));
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
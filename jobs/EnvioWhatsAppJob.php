<?php
    namespace App\Job;
    use App\Repository\CampanhaRepository;
    use App\Repository\CampanhaClienteRepository;
    use App\Repository\TemplateRepository;
    use App\Service\WhatsAppService;
    use App\Config\Database;
    class EnvioWhatsAppJob {
        private CampanhaRepository $campanhaRepo;
        private CampanhaClienteRepository $clienteRepo;
        private TemplateRepository $templateRepo;
        private WhatsAppService $whats;
        public function __construct() {
            $this->campanhaRepo = new CampanhaRepository();
            $this->clienteRepo = new CampanhaClienteRepository();
            $this->templateRepo = new TemplateRepository();
            $this->whats = new WhatsAppService();
        }
        public function executar(int $campanhaId): void {
            $clientes = $this->clienteRepo->buscarPendentes($campanhaId);
            $conteudo = $this->templateRepo->buscarConteudo($campanhaId);
            foreach ($clientes as $c) {
                $mensagem = str_replace('{nome}', $c['nome'], $conteudo);
                $res = $this->whats->enviarMensagem($c['telefone'], $mensagem);
                $status = $res['success'] ? 'enviado' : 'falha';
                $this->clienteRepo->atualizarStatus($c['cc_id'], $status);
            }
            $this->campanhaRepo->finalizar($campanhaId);
        }
    }
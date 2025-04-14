<?php
    namespace App\Job;
    class ProcessarRespostasJob {
        public function executar(array $payload): void {
            // Exemplo de estrutura recebida por webhook do WhatsApp
            // {
            //   "mensagem_id": "abc123",
            //   "resposta": "Adorei o atendimento!",
            //   "telefone": "5511999999999"
            // }
            $mensagemId = $payload['mensagem_id'] ?? '';
            $resposta = $payload['resposta'] ?? '';
            $telefone = preg_replace('/\D/', '', $payload['telefone'] ?? '');
            // Buscar cliente, campanha, mensagem original
            // Armazenar resposta na tabela nps_respostas
            // Opcional: classificar como Promotor, Neutro, Detrator
        }
    }
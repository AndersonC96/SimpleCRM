<?php
    namespace App\Model;
    class CampanhaCliente {
        public int $id;
        public int $campanha_id;
        public int $cliente_id;
        public string $agendado_para;
        public ?string $enviado_em;
        public string $status;
        public ?string $resposta;
    }
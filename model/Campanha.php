<?php
    namespace App\Model;
    class Campanha {
        public int $id;
        public string $nome;
        public string $data_inicio;
        public int $template_id;
        public string $canal;
        public string $status;
    }
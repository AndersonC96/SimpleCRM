<?php
    namespace App\Model;
    class Cliente {
        public int $id;
        public string $nome;
        public string $telefone;
        public ?string $email;
        public ?string $tags;
        public ?int $representante_id;
    }
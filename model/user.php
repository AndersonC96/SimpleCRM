<?php
    namespace App\Model;
    class User {
        public int $id;
        public string $nome;
        public string $email;
        public string $senha;
        public string $tipo; // admin, representante, operador
        public bool $ativo;
    }
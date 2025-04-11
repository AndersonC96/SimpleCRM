<?php

require __DIR__ . '/../vendor/autoload.php';

use Tisim\SimpleCrm\Services\LogService;

LogService::write('whatsapp', 'Falha ao enviar para +55999999999 - número inválido');

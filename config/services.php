<?php
    return [
        'twilio' => [
            'sid'   => $_ENV['TWILIO_SID'] ?? '',
            'token' => $_ENV['TWILIO_TOKEN'] ?? '',
            'from'  => $_ENV['TWILIO_FROM'] ?? '',
        ],
        'quickchart' => [
            'base_url' => 'https://quickchart.io',
        ],
        // Exemplo adicional: serviço de e-mail
        'mail' => [
            'host' => $_ENV['MAIL_HOST'] ?? '',
            'port' => $_ENV['MAIL_PORT'] ?? '',
            'username' => $_ENV['MAIL_USERNAME'] ?? '',
            'password' => $_ENV['MAIL_PASSWORD'] ?? '',
        ],
    ];
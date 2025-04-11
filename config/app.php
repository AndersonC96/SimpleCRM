<?php
    return [
        'name' => $_ENV['APP_NAME'] ?? 'SimpleCRM',
        'env'  => $_ENV['APP_ENV'] ?? 'production',
        'debug' => $_ENV['APP_DEBUG'] ?? false,
    ];
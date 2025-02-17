<?php
    /**
    * Arquivo de Configuração
    *
    * Este arquivo carrega as configurações essenciais para o projeto,
    * como variáveis de ambiente, timezone, e constantes de configuração.
    * Certifique-se de que o arquivo .env esteja presente na raiz do projeto.
    */
    // Habilita a exibição de erros durante o desenvolvimento.
    // Em produção, considere desativar a exibição de erros.
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // Define o timezone padrão (ajuste conforme sua localidade)
    date_default_timezone_set('America/Sao_Paulo');
    // Carrega o autoload do Composer (necessário para carregar a biblioteca vlucas/phpdotenv)
    require_once __DIR__ . '/../vendor/autoload.php';
    // Define o caminho onde o arquivo .env está localizado (normalmente, na raiz do projeto)
    $envPath = __DIR__ . '/../';
    // Verifica se o arquivo .env existe
    if (!file_exists($envPath . '.env')) {
        die("Erro: O arquivo .env não foi encontrado no caminho {$envPath}. Certifique-se de criá-lo e definir as variáveis necessárias.");
    }
    // Carrega as variáveis de ambiente usando a biblioteca vlucas/phpdotenv
    $dotenv = Dotenv\Dotenv::createImmutable($envPath);
    $dotenv->load();
    // Lista de variáveis essenciais que devem estar definidas no .env
    //$required_env_vars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'BASE_URL'];
    $required_env_vars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'BASE_URL'];
    // Valida se todas as variáveis essenciais estão definidas e não estão vazias
    foreach ($required_env_vars as $var) {
        if (empty($_ENV[$var])) {
            die("Erro: A variável de ambiente {$var} não está definida ou está vazia no arquivo .env.");
        }
    }
    // Define constantes a partir das variáveis de ambiente
    define('DB_HOST', $_ENV['DB_HOST']);
    define('DB_NAME', $_ENV['DB_NAME']);
    define('DB_USER', $_ENV['DB_USER']);
    define('DB_PASS', $_ENV['DB_PASS']);
    define('BASE_URL', $_ENV['BASE_URL']);
    // Outras configurações podem ser definidas abaixo, por exemplo:
    define('APP_ENV', $_ENV['APP_ENV'] ?? 'production');
    define('APP_DEBUG', $_ENV['APP_DEBUG'] ?? false);
    // ====================== Configurações Adicionais ======================
    // Você pode adicionar aqui configurações adicionais, como chaves de API, limites, etc.
    // Exemplo: Configurações de APIs externas
    define('WHATSAPP_API_URL', $_ENV['WHATSAPP_API_URL'] ?? 'https://api.whatsapp.com/sendMessage');
    define('WHATSAPP_API_KEY', $_ENV['WHATSAPP_API_KEY'] ?? die("WHATSAPP_API_KEY não definido no .env"));
    define('GOOGLE_MAPS_API_KEY', $_ENV['GOOGLE_MAPS_API_KEY'] ?? die("GOOGLE_MAPS_API_KEY não definido no .env"));
    // Exemplo: Configurações da aplicação
    define('DEFAULT_PAGINATION_LIMIT', $_ENV['DEFAULT_PAGINATION_LIMIT'] ?? 10); // Número padrão de itens por página
    define('MAX_UPLOAD_SIZE', $_ENV['MAX_UPLOAD_SIZE'] ?? 10485760); // Tamanho máximo de upload (em bytes), ex.: 10MB
    define('APP_VERSION', $_ENV['APP_VERSION'] ?? '1.0.0');
    // Exemplo: Configurações de segurança e criptografia
    define('ENCRYPTION_KEY', $_ENV['ENCRYPTION_KEY'] ?? die("ENCRYPTION_KEY não definido no .env"));
    define('SECRET_TOKEN', $_ENV['SECRET_TOKEN'] ?? die("SECRET_TOKEN não definido no .env"));
    // ========================================================================
    // Fim do arquivo de configuração
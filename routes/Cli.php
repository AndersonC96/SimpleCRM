<?php
    use Tisim\SimpleCrm\Services\WhatsAppService;
    use Tisim\SimpleCrm\Models\Invite;
    $argv = $_SERVER['argv'];
    $command = $argv[1] ?? null;
    switch ($command) {
        case 'cli:send-pending':
            $invites = Invite::whereNull('sent_at')->get();
            $whats = new WhatsAppService();
            foreach ($invites as $invite) {
                $link = "http://localhost/SimpleCRM/respond?token={$invite->token}";
                $message = "Olá! Responda nossa pesquisa: $link";
                if ($whats->sendMessage($invite->phone, $message)) {
                    $invite->sent_at = now();
                    $invite->save();
                    echo "✅ Enviado para {$invite->phone}\n";
                } else {
                    echo "❌ Falha para {$invite->phone}\n";
                }
            }
            break;
        default:
            echo "Comando inválido. Exemplo: php index.php cli:send-pending\n";
    }
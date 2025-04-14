<?php
    namespace App\Middleware;
    use Symfony\Component\Security\Csrf\CsrfToken;
    use Symfony\Component\Security\Csrf\CsrfTokenManager;
    class CsrfMiddleware {
        public static function validate(string $token): bool {
            $manager = new CsrfTokenManager();
            return $manager->isTokenValid(new CsrfToken('form_token', $token));
        }
    }
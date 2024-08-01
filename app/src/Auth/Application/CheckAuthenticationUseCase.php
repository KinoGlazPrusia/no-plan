<?php
namespace App\Auth\Application;

use Exception;
use App\Auth\Domain\JWToken;
use App\Core\Infrastructure\Interface\IUseCase;

class CheckAuthenticationUseCase implements IUseCase {
    public function __invoke(): Object | null {
        $session_token = null;

        try {
            $session_token = JWToken::verifyCookie();
            if(!$session_token) return null;
        } 
        catch (Exception $e) {
            throw $e;
        }

        return $session_token;
    }
}
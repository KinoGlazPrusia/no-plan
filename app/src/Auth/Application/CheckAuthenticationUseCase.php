<?php
namespace App\Auth\Application;

use Exception;
use App\Auth\Domain\JWToken;
use App\Core\Infrastructure\Interface\IUseCase;

class CheckAuthenticationUseCase implements IUseCase {
    public function __invoke(): bool {
        try {
            if(!JWToken::verifyCookie()) return false;
        } 
        catch (Exception $e) {
            throw $e;
        }

        return true;
    }
}
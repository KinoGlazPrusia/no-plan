<?php
namespace App\Auth\Application;

use App\Auth\Domain\JWToken;
use App\Core\Infrastructure\Interface\IUseCase;

class CheckAuthenticationUseCase implements IUseCase {
    public function __invoke(): Object {
        try {
            return JWToken::verifyCookie();
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}
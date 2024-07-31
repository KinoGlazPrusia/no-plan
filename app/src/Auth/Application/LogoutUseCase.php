<?php
namespace App\Auth\Application;

use Exception;
use App\Auth\Domain\JWToken;
use App\Core\Infrastructure\Interface\IUseCase;

class LogoutUseCase implements IUseCase {
    public function __invoke() {
        try {
            if(!JWToken::verifyCookie()) {
                throw new Exception('Something went wrong while checking the token');
            }

            session_destroy();
            setcookie('session_token', '', time() - 3600);
        } 
        catch (Exception $e) {
            throw $e;
        }
    }
}
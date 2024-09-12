<?php
namespace App\Auth\Application;

use Exception;
use App\Auth\Domain\JWToken;
use App\Core\Infrastructure\Interface\IUseCase;

/**
 * Caso de uso para manejar el proceso de cierre de sesión.
 */
class LogoutUseCase implements IUseCase {
    /**
     * Maneja el proceso de cierre de sesión.
     *
     * @return void
     * @throws Exception Si ocurre algún error durante el proceso de verificación del token o cierre de sesión.
     */
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
<?php
namespace App\Auth\Application;

use App\Auth\Domain\JWToken;
use App\Core\Infrastructure\Interface\IUseCase;

/**
 * Caso de uso para verificar la autenticación del usuario.
 */
class CheckAuthenticationUseCase implements IUseCase {
    /**
     * Verifica la autenticación del usuario mediante la verificación del token JWT en las cookies.
     *
     * @return Object Retorna la información del usuario autenticado.
     * @throws \Exception Si ocurre algún error durante la verificación del token.
     */
    public function __invoke(): Object {
        try {
            return JWToken::verifyCookie();
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}
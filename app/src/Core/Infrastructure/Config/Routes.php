<?php
namespace App\Core\Infrastructure\Config;

/* AUTH */
use App\Auth\Infrastructure\AuthController;
use App\Auth\Application\LoginUseCase;

use App\User\Infrastructure\UserController;
use App\User\Application\RegisterUserUseCase;


/**
 * Clase Routes que gestiona las rutas definidas en la aplicación.
 */
class Routes
{
    /**
     * Verifica si una ruta existe para un método HTTP y path específicos.
     *
     * @param string $method Método HTTP (por ejemplo, GET, POST).
     * @param string $path Path de la URL.
     * @return bool Retorna true si la ruta existe, false en caso contrario.
     */
    public static function routeExists(string $method, string $path): bool {
        return isset(self::getAll()[$method][$path]) ? true : false;
    } 

    /**
     * Obtiene todas las rutas definidas en la aplicación.
     *
     * @return array Arreglo de todas las rutas.
     */
    public static function getAll() {
        return [
            'GET' => [
                'login' => [
                    'controller' => [AuthController::class, 'login'],
                    'logic' => new LoginUseCase()
                ],
                'register' => [
                    'controller' => [UserController::class, 'register'],
                    'logic' => new RegisterUserUseCase()
                ]
            ]
        ];
    }
}
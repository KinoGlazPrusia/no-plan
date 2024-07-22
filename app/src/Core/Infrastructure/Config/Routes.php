<?php
namespace App\Core\Infrastructure\Config;

use App\Core\Infrastructure\Controller\BaseController;
use App\Auth\Infrastructure\AuthController;

use App\User\Application\LoginUseCase;


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
                    'controller' => [BaseController::class, 'login'],
                    'logic' => new LoginUseCase()
                ],
                'auth' => [
                    'controller' => [AuthController::class, 'login'],
                    'logic' => new LoginUseCase()
                ]
            ]
        ];
    }
}
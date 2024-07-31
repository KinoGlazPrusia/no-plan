<?php
namespace App;

/* CORE */
use App\Core\Infrastructure\Database\MySqlDatabase;

/* AUTH */
use App\Auth\Infrastructure\AuthController;
use App\Auth\Infrastructure\AuthRepository;
use App\Auth\Application\LoginUseCase;
use App\Auth\Application\EmailExistsUseCase;

/* USER */
use App\User\Infrastructure\UserController;
use App\User\Infrastructure\UserRepository;
use App\User\Application\RegisterUserService;


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
        // LA INYECCIÓN DE DEPENDENCIAS (DI) SE MANEJA DESDE AQUÍ
        // SE INYECTA UNA NUEVA INSTANCIA DE LA DEPENDENCIA EN LAS CLASES QUE LA ESPERAN
        // LAS CLASES QUE ESPERAN UNA DI, ESPERAN COMO PARÁMETRO UNA INTERFAZ (ABSTRACCIÓN)
        return [
            'GET' => [
                'email-exists' => [
                    'controller' => [AuthController::class, 'emailExists'],
                    'logic' => new EmailExistsUseCase(new AuthRepository(new MySqlDatabase)),
                    'access' => 'public'
                ]
            ],
            'POST' => [
                'login' => [
                    'controller' => [AuthController::class, 'login'],
                    'logic' => new LoginUseCase(new AuthRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'register' => [
                    'controller' => [UserController::class, 'register'],
                    'logic' => new RegisterUserService(new UserRepository(new MySqlDatabase)),
                    'access' => 'public'
                ]
            ]
        ];
    }
}
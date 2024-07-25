<?php
namespace App\User\Infrastructure;

use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;
use App\User\Infrastructure\UserRepository;
use App\Core\Infrastructure\Database\MySqlDatabase;
use App\User\Domain\UserGenre;

class UserController {
    public static function register(Request $request, IUseCase | IService $registerUser): void {
        // Validamos la request
        /* if (!$request->validateQuery([
            'name', 
            'lastname',
            'email',
            'password',
            'conf_password',
            'birth_date',
            'genre',
            'user_img'
        ])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        } */

        // Obtenemos los datos de la request
        /* $name = $request->query['name'];
        $lastname = $request->query['lastname'];
        $email = $request->query['email']; */
        // Sanitizamos los datos
        // Validamos los datos
        
        // Extraemos los datos de la imagen y la preparamos para guardarla en servidor una vez creado el usuario
        // En el momento de activar la cuenta si no se activa la imagen ha de eliminarse.


        // Ejecutamos la lógica de negocio (crear un usuario)
        $registeredUser = $registerUser(
            Sanitizer::sanitizeName('name'),
            Sanitizer::sanitizeName('lastname'),
            'email@gmail.com',
            '1234',
            '2000-01-01',
            UserGenre::MALE,
            'profile_img_url'
        );

        // Si recibimos un usuario
        $registeredUser ? 
            Response::json('success', 200, 'Registered user') 
            :
            Response::jsonError(400, 'Invalid data');
    }
}
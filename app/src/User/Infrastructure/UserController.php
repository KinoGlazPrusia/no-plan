<?php
namespace App\User\Infrastructure;

use App\Env;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;


class UserController {
    public static function register(Request $request, IUseCase | IService $registerUser): void {
        // Validamos la request
        if (!$request->validateQuery([
            'email', 
            'name',
            'lastname',
            'password',
            'birth_date',
            'genre'
        ])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        // Obtenemos los datos de la request y los sanitizamos
        $email = Sanitizer::sanitizeEmail($request->query['email']);
        $name = Sanitizer::sanitizeName($request->query['name']);
        $lastname = Sanitizer::sanitizeName($request->query['lastname']);
        $password = $request->query['password'];
        $birth_date = Sanitizer::sanitizeDate($request->query['birth_date']);
        $genre = Sanitizer::sanitizeString($request->query['genre']);
        
        // Creamos una url para guardar la imagen
        $image = $_FILES['image'];
        if (!is_uploaded_file($image['tmp_name'])) {
            Response::jsonError(400, 'Invalid image');
        }

        // Validamos todos los datos recogidos
        $validityMessage = array_merge(
            Validator::validateEmail($email),
            Validator::validateName($name),
            Validator::validateName($lastname),
            Validator::validateDate($birth_date),
            Validator::validateGenre($genre),
            Validator::validateUploadedImage($image)
        );
        
        if (count($validityMessage) > 0) {
            Response::jsonError(400, implode(', ', $validityMessage));
        }
        
        // Ejecutamos la lógica de negocio (crear un usuario)
        $isUserRegistered = $registerUser(
            $email,
            $name,
            $lastname,
            $password,
            $birth_date,
            $genre,
            $image
        );

        // Si recibimos un usuario
        /* $registeredUser ? 
            Response::json('success', 200, 'Registered user') 
            :
            Response::jsonError(400, 'Invalid data'); */
    }
}
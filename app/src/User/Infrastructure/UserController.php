<?php
namespace App\User\Infrastructure;

use Exception;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;

/**
 * Controlador para gestionar las solicitudes relacionadas con el registro de usuarios.
 */
class UserController {
    /**
     * Registra un nuevo usuario.
     *
     * @param Request $request Objeto de solicitud que contiene los datos del usuario.
     * @param IUseCase|IService $registerUser Caso de uso o servicio que gestiona el registro del usuario.
     * @return void
     */
    public static function register(Request $request, IUseCase | IService $registerUser): void {
        // Validamos la solicitud
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

        // Obtenemos los datos de la solicitud y los sanitizamos
        $email = Sanitizer::sanitizeEmail($request->query['email']);
        $name = Sanitizer::sanitizeName($request->query['name']);
        $lastname = Sanitizer::sanitizeName($request->query['lastname']);
        $password = $request->query['password'];
        $birth_date = Sanitizer::sanitizeDate($request->query['birth_date']);
        $genre = Sanitizer::sanitizeString($request->query['genre']);
        
        // Creamos una URL para guardar la imagen
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
        $isUserRegistered = false;
        $error = null;
        
        try {
            $isUserRegistered = $registerUser(
                $email,
                $name,
                $lastname,
                $password,
                $birth_date,
                $genre,
                $image,
                ['admin', 'user']
            );
        } 
        catch (Exception $e) {
            $error = $e->getMessage();
        }

        // Respondemos según el resultado del registro
        $isUserRegistered ? 
            Response::json('success', 200, 'Registered user') 
            :
            Response::jsonError(400, $error);
    }
}

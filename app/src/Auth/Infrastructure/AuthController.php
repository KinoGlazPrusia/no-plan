<?php
namespace App\Auth\Infrastructure;

use Exception;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;
use App\Core\Infrastructure\Database\MySqlDatabase;
use App\Auth\Infrastructure\AuthRepository;

use App\Auth\Domain\JWToken;

class AuthController {
    public static function login(Request $request, IUseCase | IService $login): void {
        // Chequeamos si el usuario ya está logueado
        if (isset($_COOKIE['session_token'])) {
            // Esto solo está con fines de DEBUG (eliminar en producción)
            $decodedToken = JWToken::decodeToken($_COOKIE['session_token']);
            Response::json('error', 200, 'User already logged in', ['token' => $decodedToken]);
        }

        // Validamos la request
        if (!$request->validateQuery(['email', 'password'])) {
            Response::jsonError(400, 'Expected parameters [email, password]');
        }

        // Obtenemos los datos de la request
        $email = $request->query['email'];
        $password = $request->query['password'];

        // Sanitizamos los datos
        $email = Sanitizer::sanitizeEmail($email);

        // Validamos los datos
        $validityMessage = Validator::validateEmail($email);

        if (count($validityMessage) > 0) {
            Response::jsonError(400, implode(', ', $validityMessage));
        }

        try {
            $loggedUser = $login($email, $password);

            // Respuesta provisional (devolvemos los datos del usuario ¡sin el password!)
            $filteredUserData = $loggedUser->serialize();
            unset($filteredUserData['password']);
            Response::json('success', 200, 'Logged in', [$filteredUserData]);
        } 
        catch (Exception $e) {
            Response::jsonError(403, $e->getMessage());
        }
    }
}
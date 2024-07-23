<?php
namespace App\Auth\Infrastructure;

use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;
use App\Core\Infrastructure\Database\MySqlDatabase;
use App\Auth\Infrastructure\AuthRepository;

class AuthController {
    public static function login(Request $request, IUseCase | IService $businessLogic): void {
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
        if (!Validator::validateEmail($email)) {
            Response::jsonError(400, 'Invalid email');
        }

        $loggedUser = $businessLogic(
            new AuthRepository(new MySqlDatabase()),
            $email, 
            $password
        );

        if (!$loggedUser) Response::jsonError(400, 'Invalid email or password');

        Response::json('success', 200, 'Logged in', [$loggedUser]);
    }
}
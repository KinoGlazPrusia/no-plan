<?php
namespace App\Core\Infrastructure\Controller;

use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;

class BaseController
{
    public static function login(Request $request, IUseCase | IService $businessLogic): void {
        if (!$request->validateQuery(['id'])) 
        Response::jsonError(400, 'Expected parameters [email, password]');

        $res = $businessLogic(); // Se invoca el caso de uso o servicio
        // Analizamos el resultado del caso de uso y devolvemos el JSON correspondiente al resultado

        Response::json('success', 200, 'Logged in', [$res]);
    }

    public static function logout(Request $request): void {
        if (!$request->validateQuery()) Response::jsonError(400, 'Not expecting any parameters');

        Response::json('success', 200, 'Logged out');
    }
}   
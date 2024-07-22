<?php
namespace App\Auth\Infrastructure;

use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;

class AuthController {
    public static function login(Request $request, IUseCase | IService $businessLogic): void {
        echo "Hola mundo! Login";
    }
}
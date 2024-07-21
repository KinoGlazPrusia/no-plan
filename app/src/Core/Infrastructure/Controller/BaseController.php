<?php
namespace App\Core\Infrastructure\Controller;

use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;

class BaseController
{
    public static function login(Request $request): void {
        if (!$request->validateQuery(['email', 'password'])) Response::jsonError(400, 'Expected parameters [email, password]');
        

        Response::json('success', 200, 'Logged in');
    }

    public static function logout(Request $request): void {
        if (!$request->validateQuery()) Response::jsonError(400, 'Not expecting any parameters');

        Response::json('success', 200, 'Logged out');
    }
}   
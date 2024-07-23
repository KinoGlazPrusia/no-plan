<?php
namespace App\Auth\Domain;
require_once dirname(__DIR__) . '/../../../secret/Secret.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Secret\Secret;

class JWToken {
    public static function generateToken(array $payload): string {
        $key = Secret::JWT_SECRET_KEY;
        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }

    public static function verifyToken(string $jwt): Object | string {
        $error = null;

        try {
            $decoded = JWT::decode($jwt, new Key(Secret::JWT_SECRET_KEY, 'HS256'));
        }
        catch (\Exception $e) {
            $error = $e->getMessage();
        }
        return $error ? $error : $decoded;
    }
}

/* 
Ejemplo de uso:

$jwt = JWToken::generateToken([
    'id' => 24,
    'isLoggedIn' => true
]);
var_dump(JWToken::verifyToken($jwt));
*/
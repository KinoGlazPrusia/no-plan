<?php
namespace App\Auth\Domain;
require_once dirname(__DIR__) . '/../../../secret/Secret.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Secret\Secret;
use App\User\Domain\User;
use App\Env;

class JWToken {
    public static function encodeToken(User $user, $validityTime): string {
        $key = Secret::JWT_SECRET_KEY;
        $issuedAt = time();
        $payload = [
            'iss' => Env::APP_HOST,                 // issuer
            'sub' => $user->id,                     // subject
            'aud' => Env::APP_HOST,                 // audience
            'iat' => $issuedAt,                     // issued at
            'nbf' => $issuedAt,                     // not before
            'exp' => $issuedAt + $validityTime,     // expiration (segundos)
            'jti' => bin2hex(random_bytes(16)),     // JWT ID
            'uid' => $user->id,                     // User ID
            'roles' => ['admin', 'user'],           // Roles
            'email' => $user->email                 // Email
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }

    public static function decodeToken(string $jwt): Object | string {
        $error = null;

        try {
            $decoded = JWT::decode($jwt, new Key(Secret::JWT_SECRET_KEY, 'HS256'));
        }
        catch (\Exception $e) {
            $error = $e->getMessage();
        }
        return $error ? $error : $decoded;
    }

    public static function generateCookie(User $user, $validityTime) {
        $jwt = self::encodeToken($user, $validityTime);

        setcookie('session_token', $jwt, time() + $validityTime, secure: true, httponly:true);
    }

    public static function verifyCookie(): bool {
        if (!isset($_COOKIE['session_token'])) return false;

        $verification = self::decodeToken($_COOKIE['session_token']);

        // Verificamos que los datos de sesión estén seteados
        if (
            !isset($_SESSION['uid']) ||
            !isset($_SESSION['userEmail'])
        ) return false;
        
        // Verificamos que los datos del token coincidan con los datos de sesión
        if (
            gettype($verification) !== Object || // Si $verification devuelve un string, es que hay un error
            $verification['uid'] !== $_SESSION['uid'] ||
            $verification['email'] !== $_SESSION['userEmail']
        ) return false;

        return true;
    }
}
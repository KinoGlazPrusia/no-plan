<?php
namespace App\Auth\Domain;
require_once dirname(__DIR__) . '/../../../secret/Secret.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Secret\Secret;

class JWToken {
    public static function generateToken(User $user, $validityTime): string {
        $key = Secret::JWT_SECRET_KEY;
        $payload = [
            'iss' => Env::APP_HOST,                 // issuer
            'sub' => $user->id,                     // subject
            'aud' => Env::APP_HOST,                 // audience
            'iat' => time(),                        // issued at
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

    public static function generateCookie(User $user, $validityTime) {
        session_start();

        $jwt = self::generateToken($user, $validityTime);

        setcookie('token', $jwt, time() + $validityTime, secure: true, httponly:true);
    }

    public static function verifyCookie(): bool {
        session_start();
        
        if (!isset($_COOKIE['token'])) return false;

        $verification = self::verifyToken($_COOKIE['token']);

        if (gettype($verification) !== Object) return false;

        return true;
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
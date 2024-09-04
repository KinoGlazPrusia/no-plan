<?php
namespace App\Auth\Domain;
require_once dirname(__DIR__) . '/../../../secret/Secret.php';

use App\Env;
use App\User\Domain\User;
use App\Auth\Application\Exception\InvalidAccessTokenException;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Secret\Secret;


class JWToken {
    public static function encodeToken(User $user, array $roles, $validityTime): string {
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
            'roles' => array_map(function($role) {  // Roles
                return $role->role;
            }, $roles),  
            'email' => $user->email                 // Email
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }

    public static function decodeToken(string $jwt): Object {
        try {
            $decoded = JWT::decode($jwt, new Key(Secret::JWT_SECRET_KEY, 'HS256'));
            return $decoded;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    public static function generateCookie(User $user, array $roles, $validityTime): void {
        try {
            $jwt = self::encodeToken($user, $roles, $validityTime);
            setcookie('session_token', $jwt, time() + $validityTime, secure: true, httponly:true);
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    public static function verifyCookie(): Object {
        try {
            if (!isset($_COOKIE['session_token'])) throw new InvalidAccessTokenException();
            $verification = self::decodeToken($_COOKIE['session_token']);

            // Si los datos de sesión no están seteados los recuperamos
            if (
                !isset($_SESSION['uid']) ||
                !isset($_SESSION['userEmail'])
            ) {
                $_SESSION['uid'] = $verification->uid;
                $_SESSION['userEmail'] = $verification->email;
            }

            // Verificamos que los datos del token coincidan con los datos de sesión
            if (
                gettype($verification) !== 'object' || // Si $verification devuelve un string, es que hay un error
                $verification->uid !== $_SESSION['uid'] ||
                $verification->email !== $_SESSION['userEmail']
            ) throw new InvalidAccessTokenException();

            return $verification;
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}
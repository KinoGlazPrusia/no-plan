<?php
namespace App\Auth\Domain;
require_once dirname(__DIR__) . '/../../../secret/Secret.php';

use App\Env;
use App\User\Domain\User;
use App\Auth\Application\Exception\InvalidAccessTokenException;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Secret\Secret;

/**
 * Clase que maneja la generación, decodificación y verificación de tokens JWT.
 */
class JWToken {

    /**
     * Codifica un token JWT con los datos del usuario y roles.
     *
     * @param User $user El objeto del usuario.
     * @param array $roles Lista de roles asignados al usuario.
     * @param int $validityTime El tiempo de validez del token en segundos.
     * @return string El token JWT generado.
     * @throws \Exception Si ocurre un error durante la generación del token.
     */
    public static function encodeToken(User $user, array $roles, $validityTime): string {
        try {
            $key = Secret::JWT_SECRET_KEY;
            $issuedAt = time();
            $payload = [
                'iss' => Env::$APP_HOST,                 // issuer
                'sub' => $user->id,                     // subject
                'aud' => Env::$APP_HOST,                 // audience
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
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Decodifica un token JWT.
     *
     * @param string $jwt El token JWT a decodificar.
     * @return object El objeto decodificado que contiene los datos del token.
     * @throws \Exception Si ocurre un error durante la decodificación.
     */
    public static function decodeToken(string $jwt): Object {
        try {
            $decoded = JWT::decode($jwt, new Key(Secret::JWT_SECRET_KEY, 'HS256'));
            return $decoded;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Genera una cookie con el token JWT.
     *
     * @param User $user El objeto del usuario.
     * @param array $roles Lista de roles asignados al usuario.
     * @param int $validityTime El tiempo de validez de la cookie en segundos.
     * @return void
     * @throws \Exception Si ocurre un error durante la generación de la cookie.
     */
    public static function generateCookie(User $user, array $roles, $validityTime): void {
        try {
            $jwt = self::encodeToken($user, $roles, $validityTime);
            setcookie('session_token', $jwt, time() + $validityTime, httponly:true);
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Verifica la validez de la cookie con el token JWT.
     *
     * @return object El objeto decodificado que contiene los datos del token.
     * @throws InvalidAccessTokenException Si el token es inválido o no coincide con los datos de la sesión.
     * @throws \Exception Si ocurre otro error durante la verificación.
     */
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
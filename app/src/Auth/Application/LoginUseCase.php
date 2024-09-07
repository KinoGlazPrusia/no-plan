<?php
namespace App\Auth\Application;

use App\Env;
use App\Auth\Domain\JWToken;
use App\User\Domain\User;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IRepository;

class LoginUseCase implements IUseCase {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke($email, $password): User | null {
        // Recuperamos el usuario
        $user = null;
        $roles = [];

        try {
            $user = $this->repository->getUserByEmail($email);
            
            // Se puede retornar directamente $user pero es por legibilidad
            // Esta excepción podría retornarse directamente desde el repository
            if (!$user) throw new \Exception('User don\'t exist'); 

            $roles = $this->repository->getUserRoles($user);
        } 
        catch (\Exception $e) {
            throw $e;
        }

        // Chequeamos las credenciales
        try {
            password_verify($password, $user->password);
            // Si las credenciales son válidas
            // Guardamos el id, el email y los roles del usuario en la sesión
            $_SESSION['uid'] = $user->id;
            $_SESSION['userEmail'] = $user->email;
            $_SESSION['userName'] = $user->name . ' ' . $user->lastname;
            $_SESSION['roles'] = $roles;
            
            // Generamos el token de sesión y su cookie
            JWToken::generateCookie($user, $roles, Env::SESSION_TOKEN_EXPIRATION_TIME);

            // Devolvemos el usuario
            return $user;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
}
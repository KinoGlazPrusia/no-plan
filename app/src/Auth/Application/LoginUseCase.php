<?php
namespace App\Auth\Application;

use Exception;
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
            // [x] Recuperar los roles del usuario
            $roles = $this->repository->getUserRoles($user);
        } 
        catch (Exception $e) {
            throw $e;
        }

        if (!$user) throw new Exception('User don\'t exist'); // Se puede retornar directamente $user pero es por legibilidad

        // Chequeamos las credenciales
        try {
            password_verify($password, $user->password);
            // Si las credenciales son válidas
            // Guardamos el id, el email y los roles del usuario en la sesión
            $_SESSION['uid'] = $user->id;
            $_SESSION['userEmail'] = $user->email;
            $_SESSION['roles'] = $roles;
            
            // [x] Integrar los roles en el JWT
            // Generamos el token de sesión y su cookie
            JWToken::generateCookie($user, $roles, (3600*24));
        }
        catch (Exception $e) {
            throw $e;
        }

        // Devolvemos el usuario
        return $user;
    }
}
<?php
namespace App\Auth\Application;

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
        $user = $this->repository->getUserByEmail($email);

        if (!$user) return null;

        // Chequeamos las credenciales
        if (!password_verify($password, $user->password)) return null;

        // Si las credenciales son válidas
        // Guardamos el id y el email del usuario en la sesión
        // Aquí se podrían añadir roles
        $_SESSION['uid'] = $user->id;
        $_SESSION['userEmail'] = $user->email;

        // Generamos el token de sesión y su cookie
        JWToken::generateCookie($user, (3600*24));

        // Devolvemos el usuario
        return $user;
    }
}
<?php
namespace App\Auth\Application;

use App\Env;
use App\Auth\Domain\JWToken;
use App\User\Domain\User;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IRepository;

/**
 * Caso de uso para manejar el proceso de inicio de sesión.
 */
class LoginUseCase implements IUseCase {
    /**
     * @var IRepository El repositorio para acceder a los datos de usuario.
     */
    private IRepository $repository;

    /**
     * Constructor de la clase.
     *
     * @param IRepository $repository El repositorio para acceder a los datos de usuario.
     */
    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Maneja el proceso de inicio de sesión.
     *
     * @param string $email El correo electrónico del usuario.
     * @param string $password La contraseña del usuario.
     * @return User|null Retorna un objeto User si el inicio de sesión es exitoso, null en caso contrario.
     * @throws \Exception Si ocurre algún error durante el proceso de inicio de sesión.
     */
    public function __invoke($email, $password): User | null {
        // Recuperamos el usuario
        $user = null;
        $roles = [];

        try {
            $user = $this->repository->getUserByEmail($email);
            
            // Se puede retornar directamente $user pero es por legibilidad
            // Esta excepción podría retornarse directamente desde el repository
            if (!$user) throw new \Exception('Incorrect email or password'); 

            $roles = $this->repository->getUserRoles($user);
        } 
        catch (\Exception $e) {
            throw $e;
        }

        // Chequeamos las credenciales
        try {
            if (!password_verify($password, $user->password)) {
                throw new \Exception('Incorrect email or password');
            }
            
            // Si las credenciales son válidas
            // Guardamos el id, el email y los roles del usuario en la sesión
            $_SESSION['uid'] = $user->id;
            $_SESSION['userEmail'] = $user->email;
            $_SESSION['userName'] = $user->name . ' ' . $user->lastname;
            $_SESSION['roles'] = $roles;
            
            // Generamos el token de sesión y su cookie
            JWToken::generateCookie($user, $roles, Env::$SESSION_TOKEN_EXPIRATION_TIME);

            // Devolvemos el usuario
            return $user;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
}
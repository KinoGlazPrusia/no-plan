<?php 
namespace App\User\Application;

use Exception;
use App\User\Domain\UserRole;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;

use App\User\Application\SaveNewUserUseCase;
use App\User\Application\StoreUserAvatarUseCase;
use App\User\Application\AssignRolesToNewUserUseCase;

/**
 * Servicio para registrar un nuevo usuario.
 */
class RegisterUserService implements IService {
    private IRepository $repository;

    /**
     * Constructor de RegisterUserService.
     *
     * @param IRepository $repository Repositorio para realizar operaciones de almacenamiento de usuario.
     */
    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Registra un nuevo usuario con la información proporcionada.
     *
     * @param string $email Correo electrónico del nuevo usuario.
     * @param string $name Nombre del nuevo usuario.
     * @param string $lastname Apellido del nuevo usuario.
     * @param string $password Contraseña del nuevo usuario.
     * @param string $birth_date Fecha de nacimiento del nuevo usuario.
     * @param string $genre Género del nuevo usuario.
     * @param array $image Información de la imagen del perfil del usuario.
     * @param string[] $roles Lista de roles a asignar al nuevo usuario.
     * @return bool Retorna true si el registro es exitoso, de lo contrario lanza una excepción.
     * @throws Exception Si ocurre un error durante el proceso de registro.
     */
    public function __invoke(
        string $email,
        string $name,
        string $lastname,
        string $password,
        string $birth_date,
        string $genre,
        array $image,
        array $roles
    ): bool {
        
        try {
            // Caso de uso para guardar al usuario
            $newUser = SaveNewUserUseCase::save(
                $this->repository,
                $email,
                $name,
                $lastname,
                $password,
                $birth_date,
                $genre,
                $image
            );

            // Caso de uso para guardar la imagen del usuario en servidor
            StoreUserAvatarUseCase::storeAvatarImage($image['tmp_name'], $newUser->profile_img_url);

            // [ ] Implementar caso de uso para enviar email de verificación de cuenta

            // Caso de uso para asignar roles al usuario
            $roleList = array_map(function($role) {
                return new UserRole($role);
            }, $roles);

            AssignRolesToNewUserUseCase::assign($this->repository, $newUser, $roleList);

            return true;
        } 
        catch (Exception $e) {
            throw $e;
        }
    }
}

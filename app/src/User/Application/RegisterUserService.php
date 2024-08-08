<?php 
namespace App\User\Application;

use Exception;
use App\User\Domain\UserRole;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;

use App\User\Application\SaveNewUserUseCase;
use App\User\Application\StoreUserAvatarUseCase;
use App\User\Application\AssignRolesToNewUserUseCase;

class RegisterUserService implements IService {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

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

            // [ ] Implementar caso de uso para asignar roles al usuario
            $roleList = array_map(function($role) {
                return new UserRole($role);
            }, $roles);

            AssignRolesToNewUserUseCase::assign($this->repository, $newUser, $roleList);
        } 
        catch (Exception $e) {
            throw $e;
        }
        
        return true;
    }
}
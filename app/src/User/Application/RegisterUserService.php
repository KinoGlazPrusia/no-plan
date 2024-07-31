<?php 
namespace App\User\Application;

use Exception;
use App\Env;
use App\User\Domain\User;
use App\Auth\Domain\UUIDv4;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Interface\IUseCase;
use App\User\Infrastructure\UserRepository;

use App\User\Application\SaveNewUserUseCase;
use App\User\Application\StoreUserAvatarUseCase;

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
        array $image
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

            // Caso de uso para enviar email de verificación de cuenta
            // Pendiente de implementar
        } 
        catch (Exception $e) {
            throw $e;
        }
        
        return true;
    }
}
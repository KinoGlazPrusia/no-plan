<?php 
namespace App\User\Application;

use App\Env;
use App\User\Domain\User;
use App\Auth\Domain\UUIDv4;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Interface\IUseCase;
use App\User\Infrastructure\UserRepository;

class RegisterUserUseCase implements IUseCase {
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
        $uuid = UUIDv4::_invoke();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $profile_img_url = $this->generateImagePath($image);

        $data = (object)[
            'id' => $uuid,
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $hash,
            'birth_date' => $birth_date,
            'genre' => $genre,
            'profile_img_url' => $profile_img_url
        ];

        if (!$this->repository->save(new User($data))) return false;
        
        // Si se ha guardado el usuario, guardamos la imagen
        // En el momento de activar la cuenta si no se activa la imagen ha de eliminarse.
        if (!$this->storeAvatarImage($image['tmp_name'], $profile_img_url)) return false;

        // Si se ha guardado la imagen, devolvemos true
        return true;
    }

    public function generateImagePath(array $image): string {
        // Extraemos los datos de la imagen y la preparamos para guardarla en servidor una vez creado el usuario
        $extension = explode('/', $image['type'])[1];
        return Env::AVATAR_IMAGES_DIR . time() . random_int(0, 1000) . '.' . $extension;
    }

    public function storeAvatarImage(string $src, $dst): bool {
        return move_uploaded_file($src, $dst);
    }
}
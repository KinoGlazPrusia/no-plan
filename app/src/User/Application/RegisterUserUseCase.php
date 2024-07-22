<?php 
namespace App\User\Application;

use App\User\Domain\User;
use App\Auth\Domain\UUIDv4;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class RegisterUserUseCase implements IUseCase {
    public function __invoke(
        IRepository $repo,
        string $name,
        string $lastname,
        string $email,
        string $password,
        string $birth_date,
        string $genre,
        string $profile_img_url
    ): bool {
        $uuid = UUIDv4::_invoke();
        $hash = password_hash($password, PASSWORD_DEFAULT);

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

        return $repo->save(new User($data));
    }
}
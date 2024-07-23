<?php 
namespace App\User\Application;

use App\User\Domain\User;
use App\Auth\Domain\UUIDv4;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;
use App\User\Infrastructure\UserRepository;

class RegisterUserUseCase implements IUseCase {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(
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

        return $this->repository->save(new User($data));
    }
}
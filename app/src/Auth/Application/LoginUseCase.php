<?php
namespace App\Auth\Application;

use App\User\Domain\User;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IRepository;

class LoginUseCase implements IUseCase {
    public function __invoke(IRepository $repo, $email, $password): User | null {
        $logged = null;

        $user = $repo->getUserByEmail($email);

        return new User(
            (object)array(
                'id' => '1',
                'email' => 'test@test.com',
                'password' => '123456'
            )
        );
    }
}
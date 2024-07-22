<?php
namespace App\Auth\Application;

use App\User\Domain\User;
use App\Core\Infrastructure\Interface\IUseCase;

class LoginUseCase implements IUseCase {
    public function __invoke($email, $password): User | null {
        $logged = null;

        return new User(
            (object)array(
                'id' => '1',
                'email' => 'test@test.com',
                'password' => '123456'
            )
        );
    }
}
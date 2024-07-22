<?php
namespace App\Auth\Infrastructure;

use App\User\Domain\User;
use App\Core\Infrastructure\Repository\CoreRepository;

class AuthRepository extends CoreRepository {
    public function getUserByEmail(string $email): User | null {
        $res = $this->findBy('user', 'email', $email);

        if (count($res) === 0) return null;

        return new User($res[0]);
    }
    
}
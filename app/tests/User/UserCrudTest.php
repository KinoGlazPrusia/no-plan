<?php
namespace Tests\Core;

use PHPUnit\Framework\TestCase;
use App\User\Infrastructure\UserRepository;
use App\Core\Infrastructure\Database\MySqlDatabase;
use App\Core\Infrastructure\Service\Mock;

class UserCrudTest extends TestCase {
    private UserRepository $repository;

    public function setUp(): void {
        $this->repository = new UserRepository(new MySqlDatabase);
    }

    public function testRepositoryCanSaveNewUser(): void
    {
        $user = Mock::newUserPostData();
        fwrite(fopen('php://stdout', 'w'), print_r($user->serialize()));
        $this->assertTrue($this->repository->save($user));
    }
}
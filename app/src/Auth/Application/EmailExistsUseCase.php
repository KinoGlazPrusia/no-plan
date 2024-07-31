<?php
namespace App\Auth\Application;

use Exception;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class EmailExistsUseCase implements IUseCase {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke($email): bool {
        try {
            $res = $this->repository->findBy('user', 'email', $email);
            if (count($res) > 0) {
                return true;
            }
        } 
        catch (Exception $e) {
            throw $e;
        }

        return false;
    }
}
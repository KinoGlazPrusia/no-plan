<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class CountAllCreatedPlansUseCase implements IUseCase {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(string $userId): int {
        try {
            $count = $this->repository->countAllCreatedPlans($userId);
            return $count;
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}
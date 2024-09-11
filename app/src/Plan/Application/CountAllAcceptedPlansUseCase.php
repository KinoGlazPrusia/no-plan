<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class CountAllAcceptedPlansUseCase implements IUseCase {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(string $userId): int {
        try {
            $count = $this->repository->countAllAcceptedPlans($userId);
            return $count;
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}
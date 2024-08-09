<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class GetPlanCategoriesUseCase implements IUseCase {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(): array {
        $categories = $this->repository->fetchAllCategories();
        
        $serializedCategories = array_map(function($category) {
            return $category->serialize();
        }, $categories);

        return $serializedCategories;
    }
}
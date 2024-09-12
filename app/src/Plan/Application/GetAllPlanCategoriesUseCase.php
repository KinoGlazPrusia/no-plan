<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

/**
 * Caso de uso para obtener todas las categorías de planes.
 */
class GetAllPlanCategoriesUseCase implements IUseCase {
    /**
     * @var IRepository El repositorio para acceder a los datos.
     */
    private IRepository $repository;

    /**
     * Constructor de la clase.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     */
    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Obtiene todas las categorías de planes.
     *
     * @return array Un array de categorías de planes serializadas.
     */
    public function __invoke(): array {
        $categories = $this->repository->fetchAllCategories();

        $serializedCategories = array_map(function($category) {
            return $category->serialize();
        }, $categories);

        return $serializedCategories;
    }
}
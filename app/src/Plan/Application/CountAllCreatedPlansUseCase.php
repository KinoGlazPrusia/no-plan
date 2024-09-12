<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

/**
 * Caso de uso para contar todos los planes creados por un usuario.
 */
class CountAllCreatedPlansUseCase implements IUseCase {
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
     * Cuenta todos los planes creados por un usuario.
     *
     * @param string $userId El ID del usuario.
     * @return int La cantidad de planes creados.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
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
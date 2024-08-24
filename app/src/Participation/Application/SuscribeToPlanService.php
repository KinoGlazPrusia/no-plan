<?php
namespace App\Participation\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;

class SuscribeToPlanService implements IService {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(int $planId): void {
        try {
            // 1. Caso de uso para guardar la participación en el repositorio

            // 2. Caso de uso para notificar al creador del plan de que se ha suscrito a él a través
            // de la app

            // 3. Caso de uso para notificar al participante de que se ha suscrito al plan a través 
            // de la app

            // 4. Caso de uso para notificar al creador del plan de que se ha suscrito a él a través
            // de email

            // 5. Caso de uso para notificar al participante de que se ha suscrito al plan a través
            // de email
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}
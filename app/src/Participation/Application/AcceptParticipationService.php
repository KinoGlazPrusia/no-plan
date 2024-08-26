<?php
namespace App\Participation\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;

use App\Participation\Domain\ParticipationStatus;

class AcceptParticipationService implements IService {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(string $userId, int $planId): void {
        try {
            // 1. Caso de uso para actualizar el status de la participación
            $acceptStatus = $this->repository->findBy('participation_status', 'status', ParticipationStatus::ACCEPTED)[0];
            $this->repository->updateParticipationStatus($userId, $planId, $acceptStatus->id);
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}
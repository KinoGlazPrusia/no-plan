<?php
namespace App\Participation\Application;

/* INFRASTRUCTURE */
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;

/* DOMAIN */
use App\Notification\Domain\NotificationType;
use App\Participation\Domain\ParticipationStatus;
use App\User\Domain\User;

/* APPLICATION */
use App\Notification\Application\CreateNotificationUseCase;

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

            // 2. Caso de uso para recuperar los datos del plan, el creador y el participante
            $creator = GetPlanCreatorContactDataUseCase::fetch($this->repository, $planId);
            $participant = new User(
                $this->repository->findBy('user', 'id', $userId)[0]
            );
            $plan = $this->repository->findBy('plan', 'id', $planId)[0];

            // 3. Caso de uso para notificar al creador del plan de que la participación ha sido aceptada
            $notificationMessage = 'Has aceptado la solicitud de ' . $participant->name . ' en el plan: ' . $plan->title;
            CreateNotificationUseCase::create(
                $this->repository, 
                $creator, 
                NotificationType::PARTICIPATION_ACCEPTED, 
                $notificationMessage
            );

            // 4. Caso de uso para notificar al participante de que su petición ha sido aceptada.
            $notificationMessage = $creator->name . ' ' . $creator->lastname . ' ha aceptado tu solicitud para participar en el plan: ' . $plan->title;
            CreateNotificationUseCase::create(
                $this->repository, 
                $participant, 
                NotificationType::PARTICIPATION_ACCEPTED, 
                $notificationMessage
            );
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}
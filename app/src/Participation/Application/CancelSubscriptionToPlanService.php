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

class CancelSubscriptionToPlanService implements IService {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(int $planId): void {
        // $_SESSION['uid'] = '77ce78e7-69ae-4b3d-9b6f-fc88a11defd5'; // [ ] Eliminar este mock
        
        $userId = $_SESSION['uid'];
        try {
            // 1. Caso de uso para actualizar el status de la participación
            $cancelStatus = $this->repository->findBy('participation_status', 'status', ParticipationStatus::CANCELLED)[0];
            $this->repository->updateParticipationStatus($userId, $planId, $cancelStatus->id);

            // 2. Caso de uso para recuperar los datos del plan, el creador y el participante
            $creator = GetPlanCreatorContactDataUseCase::fetch($this->repository, $planId);
            $participant = new User(
                $this->repository->findBy('user', 'id', $userId)[0]
            );
            $plan = $this->repository->findBy('plan', 'id', $planId)[0];

            // 3. Caso de uso para notificar al creador del plan de que la participación ha sido cancelada
            $notificationMessage = $participant->name . ' ha cancelado su participación en el plan: ' . $plan->title;
            CreateNotificationUseCase::create(
                $this->repository, 
                $creator, 
                NotificationType::PARTICIPATION_CANCELLED, 
                $notificationMessage
            );

            // 4. Caso de uso para notificar al participante de que su petición ha sido cancelada.
            $notificationMessage = 'Has cancelado tu solicitud para participar en el plan: ' . $plan->title;
            CreateNotificationUseCase::create(
                $this->repository, 
                $participant, 
                NotificationType::PARTICIPATION_CANCELLED,
                $notificationMessage
            );
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}
<?php
namespace App\Participation\Application;

/* DOMINIO */
use App\Participation\Domain\Participation;
use App\Participation\Domain\ParticipationStatus;
use App\User\Domain\User;

use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Service\Helper;

class GetAllRejectedParticipationsByPlanUseCase implements IUseCase {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }
    
    public function __invoke(int $planId): array {
        try {
            $data = $this->repository->fetchParticipationsByPlan($planId, ParticipationStatus::REJECTED);
            
            $participations = array_map(function($participation) {
                return new Participation($participation);
            }, $data);

            // Llenamos la información del usuario y del status
            foreach ($participations as $participation) {
                $userData = $this->repository->findBy('user', 'id', $participation->getUserId())[0];
                $filteredUserData = Helper::filterSensitiveData([
                    'id',
                    'password',
                    'created_at',
                    'updated_at',
                    'last_connection',
                    'birth_date',
                    'genre',
                    'profile_img_url',
                    'last_connection'
                ], (array)$userData);
                $user = new User((object)$filteredUserData);

                $participationStatusData = $this->repository->findBy('participation_status', 'id', $participation->getStatusId())[0];
                $participationStatus = new ParticipationStatus($participationStatusData);

                $participation->setUserData($user->serialize(false));
                $participation->setStatus($participationStatus->getStatus());
            }

            return $participations;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
}
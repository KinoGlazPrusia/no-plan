<?php
namespace App\Participation\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Service\Helper;
use App\User\Domain\User;

class GetPlanCreatorContactDataUseCase implements IUseCase {
    public static function fetch(IRepository $repository, int $planId): User {
        $planData = $repository->findBy('plan', 'id', $planId)[0];

        $planCreatedBy = $planData->created_by_id;

        $planCreatorData = $repository->findBy('user', 'id', $planCreatedBy)[0];

        $filteredPlanCreatorData = Helper::filterSensitiveData([
            'password',
            'created_at',
            'updated_at',
            'last_connection',
            'birth_date',
            'genre',
            'profile_img_url',
            'last_connection'
        ], (array)$planCreatorData);

        $planCreator = new User((object)$filteredPlanCreatorData);
        return $planCreator;
    }
}
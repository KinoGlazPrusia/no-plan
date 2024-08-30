<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

use App\Core\Infrastructure\Service\Helper;
use App\Plan\Domain\Plan;
use App\User\Domain\User;

class GetPlanCreatorFilteredDataUseCase implements IUseCase {
    public static function fetch(IRepository $repository, Plan $plan): void {
        $planCreatorData = $repository->findBy('user', 'id', $plan->created_by_id)[0];

        $filteredPlanCreatorData = Helper::filterSensitiveData([
            'id',
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
        $plan->setCreatedBy($planCreator->serialize(false));
    }
}
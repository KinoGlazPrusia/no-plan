<?php
namespace App\Participation\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Service\Helper;
use App\User\Domain\User;

/**
 * Caso de uso para obtener los datos de contacto del creador de un plan.
 */
class GetPlanCreatorContactDataUseCase implements IUseCase {
    /**
     * Obtiene los datos de contacto del creador de un plan.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @param int $planId El ID del plan.
     * @return User Un objeto User con los datos de contacto del creador del plan.
     */
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
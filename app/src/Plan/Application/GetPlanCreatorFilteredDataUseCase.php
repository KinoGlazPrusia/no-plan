<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

use App\Core\Infrastructure\Service\Helper;
use App\Plan\Domain\Plan;
use App\User\Domain\User;

/**
 * Caso de uso para obtener y filtrar los datos del creador de un plan.
 */
class GetPlanCreatorFilteredDataUseCase implements IUseCase {
    /**
     * Obtiene los datos del creador de un plan y los filtra para eliminar información sensible.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @param Plan $plan El plan del cual se obtendrá el creador.
     * @return void
     */
    public static function fetch(IRepository $repository, Plan $plan): void {
        $planCreatorData = $repository->findBy('user', 'id', $plan->created_by_id)[0];

        // Filtra la información sensible del creador del plan
        $filteredPlanCreatorData = Helper::filterSensitiveData([
            'id',
            'password',
            'created_at',
            'updated_at',
            'last_connection',
            'genre',
            'last_connection'
        ], (array)$planCreatorData);

        $planCreator = new User((object)$filteredPlanCreatorData);
        $plan->setCreatedBy($planCreator->serialize(false));
    }
}
<?php
namespace App\Participation\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;
use App\User\Domain\User;

class GetPlanCreatorContactDataUseCase implements IUseCase {
    public static function fetch(IRepository $repository, int $planId): User {
        $planData = $repository->findBy('plan', 'id', $planId)[0];

        $planCreatedBy = $planData->created_by_id;

        $planCreatorData = $repository->findBy('user', 'id', $planCreatedBy)[0];

        $filteredPlanCreatorData = self::filterSensitiveData([
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

    // [ ] Implementar este método dentro de una clase de servicio 'Helper' o 'Utils'
    private static function filterSensitiveData(array $keys, array $data): array {
        $keys = array_flip($keys);

        return array_diff_key($data, $keys);
    }
}
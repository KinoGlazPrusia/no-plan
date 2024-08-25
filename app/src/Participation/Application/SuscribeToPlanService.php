<?php
namespace App\Participation\Application;

use App\Core\Infrastructure\Interface\IEntity;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;

use App\Participation\Domain\Participation;
use App\User\Domain\User;

class SuscribeToPlanService implements IService {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(int $planId): void {
        $_SESSION['uid'] = '77ce78e7-69ae-4b3d-9b6f-fc88a11defd5'; // [ ] Eliminar este mock

        try {
            $participationData = [
                'user_id' => $_SESSION['uid'],
                'plan_id' => $planId
            ];

            // 1. Caso de uso para recuperar el id del status que se le quiera aplicar
            // a la nueva participación, en este caso 'pending'. Por el momento simplemente
            // le pasaremos el id que ya conocemos '1'.
            $participationData['status_id'] = 1;

            echo '<pre>';
            print_r((object)$participationData);
            echo '</pre><br><br>';

            // 2. Caso de uso para guardar la participación en el repositorio
            // $this->repository->save(new Participation((object)$participationData));

            // 3. Caso de uso para recuperar los datos del autor de un plan
            $planData = $this->repository->findBy('plan', 'id', $planId)[0];
            echo '<pre>';
            print_r($planData);
            echo '</pre><br><br>';

            $planCreatedBy = $planData->created_by_id;
            echo $planCreatedBy;

            $planCreatorData = $this->repository->findBy('user', 'id', $planCreatedBy)[0];
            echo '<pre>';
            print_r($planCreatorData);
            echo '</pre><br><br>';

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
            echo '<pre>';
            print_r($planCreator->serialize(false));
            echo '</pre><br><br>';

            // 3. Caso de uso para notificar al creador del plan de que se ha suscrito a él a través
            // de la app

            // 4. Caso de uso para notificar al participante de que se ha suscrito al plan a través 
            // de la app

            // 5. Caso de uso para notificar al creador del plan de que se ha suscrito a él a través
            // de email

            // 6. Caso de uso para notificar al participante de que se ha suscrito al plan a través
            // de email
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }

    // [ ] Traspasar esta función a una clase Helper o Utils
    private static function filterSensitiveData(array $keys, array $data): array {
        $keys = array_flip($keys);

        return array_diff_key($data, $keys);
    }
}
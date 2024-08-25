<?php
namespace App\Participation\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;

use App\Participation\Domain\Participation;

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

            print_r((object)$participationData);

            // 2. Caso de uso para guardar la participación en el repositorio
            // $this->repository->save(new Participation((object)$participationData));

            // 3. Caso de uso para recuperar el id del autor de un plan
            $planData = $this->repository->findBy('plan', 'id', $planId)[0];
            $planCreatedBy = $planData->created_by_id;
            $planCreatorData = $this->repository->findBy('user', 'id', $planCreatedBy)[0];

            print_r($planData);
            print_r($planCreatorData);

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
    private function filterSensitiveData(array $keys, Object $object) {
        
    }
}
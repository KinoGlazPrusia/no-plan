<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;
use App\Plan\Application\GetPlanTimelineUseCase;
use App\Plan\Application\GetPlanCategoriesUseCase;
use App\Plan\Domain\PlanStatus;

/**
 * Servicio para obtener todos los planes en los que el usuario haya sido aceptado.
 */
class GetAllAcceptedPlansService implements IService {
    /**
     * @var IRepository El repositorio para acceder a los datos.
     */
    private IRepository $repository;    

    /**
     * Constructor de la clase.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     */
    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Obtiene todos los planes aceptados en los que el usuario ha participado.
     *
     * @param int $page El número de la página a obtener.
     * @param int $itemsPerPage La cantidad de elementos por página.
     * @return array Un array de planes aceptados.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public function __invoke(int $page, int $itemsPerPage): array {
        // $_SESSION['uid'] = '77ce78e7-69ae-4b3d-9b6f-fc88a11defd5'; // [ ] Eliminar este mock
        $userId = $_SESSION['uid'];

        $plans = array();

        try {
            // 1. Caso de uso para recoger los datos base del plan
            $plans = $this->repository->fetchAllAcceptedPlans($userId, $page, $itemsPerPage);

            // 2. Caso de uso para recuperar los datos de las categorías del plan
            foreach($plans as $plan) {
                GetPlanTimelineUseCase::fetch($this->repository, $plan);
            }

            // 3. Caso de uso para recuperar los datos del timeline del plan
            foreach($plans as $plan) {
                GetPlanCategoriesUseCase::fetch($this->repository, $plan);
            }

            // 4. Caso de uso para recuperar el status del plan
            foreach($plans as $plan) {
                $statusData = $this->repository->findBy('plan_status', 'id', $plan->status_id)[0];
                $status = new PlanStatus($statusData);
                $plan->setStatus($status->serialize());
            }

            // 5. Caso de uso para recuperar los datos del creador del plan
            foreach($plans as $plan) {
                GetPlanCreatorFilteredDataUseCase::fetch($this->repository, $plan);
            }

            return $plans;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
}
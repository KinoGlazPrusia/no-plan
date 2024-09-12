<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanStatus;

/**
 * Servicio para obtener un plan por su ID.
 */
class GetPlanByIdService implements IService {
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
     * Obtiene un plan por su ID.
     *
     * @param int $id El ID del plan.
     * @return Plan El plan encontrado.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public function __invoke(int $id): Plan {
        try {
            // 1. Caso de uso para recuperar los datos base del plan
            $planData = $this->repository->findBy('plan', 'id', $id)[0];
            $plan = new Plan($planData);

            // 2. Caso de uso para recuperar los datos del timeline del plan
            GetPlanTimelineUseCase::fetch($this->repository, $plan);

            // 3. Caso de uso para recuperar los datos del timeline del plan
            GetPlanCategoriesUseCase::fetch($this->repository, $plan);

            // 4. Caso de uso para recuperar el status del plan
            $statusData = $this->repository->findBy('plan_status', 'id', $plan->status_id)[0];
            $status = new PlanStatus($statusData);
            $plan->setStatus($status->serialize());

            // 5. Caso de uso para recuperar los datos del creador del plan (filtrados)
            GetPlanCreatorFilteredDataUseCase::fetch($this->repository, $plan);

            return $plan;

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
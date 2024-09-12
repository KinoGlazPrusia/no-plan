<?php
namespace App\Plan\Application;

/* DOMINIO */
use App\Plan\Domain\Plan;

/* APLICACION */
use App\Plan\Application\SaveNewPlanUseCase;
use App\Plan\Application\SaveTimelineStepsUseCase;
use App\Plan\Application\AssignCategoriesToPlanUseCase;
use App\Plan\Application\StorePlanImageUseCase;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Interface\IRepository;

/**
 * Servicio para crear un nuevo plan.
 */
class CreatePlanService implements IService {
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
     * Crea un nuevo plan.
     *
     * @param string $title El título del plan.
     * @param string $description La descripción del plan.
     * @param string $datetime La fecha y hora del plan.
     * @param int $max_participation El número máximo de participantes.
     * @param array $categories Las categorías a asignar al plan.
     * @param array $timeline La línea de tiempo del plan.
     * @param array $image La imagen del plan a subir.
     * @return Plan El plan creado.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public function __invoke(
        string $title,
        string $description,
        string $datetime,
        int $max_participation,
        array $categories,
        array $timeline,
        array $image
    ): Plan {
        try {
            // 1. Caso de uso para guardar el plan
            $newPlan = SaveNewPlanUseCase::save(
                $this->repository,
                $title,
                $description,
                $datetime,
                $max_participation,
                $image
            );

            // 2. Caso de uso para guardar el timeline (devuelve el mismo plan pero con el nuevo timeline y lo guarda en el repositorio)
            $newPlan = SaveTimelineStepsUseCase::save($this->repository, $newPlan, $timeline);
            
            // 3. Caso de uso para asignar categorias al plan
            $newPlan = AssignCategoriesToPlanUseCase::assign($this->repository, $newPlan, $categories);

            // 4. Caso de uso para guardar la imagen del plan en servidor
            StorePlanImageUseCase::store($image['tmp_name'], $newPlan->plan_img_url);
        } 
        catch (\Exception $e) {
            throw $e;
        }
        
        return $newPlan;
    }
}   
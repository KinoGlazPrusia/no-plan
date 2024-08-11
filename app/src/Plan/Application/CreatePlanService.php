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

class CreatePlanService implements IService {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

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
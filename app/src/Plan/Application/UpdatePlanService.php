<?php
namespace App\Plan\Application;

/* DOMINIO */
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanStatus;
use App\User\Domain\User;

/* APLICACION */
use App\Plan\Application\UpdatePlanDataUseCase;
use App\Plan\Application\StorePlanImageUseCase;
use App\Plan\Application\UpdateTimelineStepsUseCase;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;

class UpdatePlanService implements IService {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(
        int | null $id,
        string | null $title,
        string | null $description,
        string | null $datetime,
        int | null $max_participation,
        array | null $categories,
        array | null $timeline,
        array | null $image
    ): Plan {
        $_SESSION['uid'] = '77ce78e7-69ae-4b3d-9b6f-fc88a11defd5'; // [ ] Eliminar este mock
        
        try {
            // Comprobamos que el usuario que está actualmente autenticado sea el creador del plan
            $planCreator = $this->repository->findBy('plan', 'id', $id)[0]->created_by_id;
            if ($_SESSION['uid'] !== $planCreator) throw new \Exception('You are not the creator of this plan');
            
            // 1. Caso de uso para actualizar los datos base del plan
            $updatedPlan = UpdatePlanDataUseCase::update(
                $this->repository,
                $id,
                $title,
                $description,
                $datetime,
                $max_participation,
                $image
            );

            // 2. Caso de uso para actualizar los pasos de la línea de tiempo
            if ($timeline) UpdateTimelineStepsUseCase::update($this->repository, $updatedPlan, $timeline);
            
            // 3. Caso de uso para actualizar las categorías del plan
            if ($categories) {
                $updatedPlan = UpdatePlanCategoriesUseCase::update($this->repository, $updatedPlan, $categories);
            }

            // Caso de uso para guardar la imagen del plan en servidor
            // [ ] Implementar un caso de uso para eliminar la imagen anterior del plan
            if ($image) StorePlanImageUseCase::store($image['tmp_name'], $updatedPlan->plan_img_url);

            return $updatedPlan;
        } 
        catch (\Exception $e) {
            throw $e;
        }
        
    }

    
}
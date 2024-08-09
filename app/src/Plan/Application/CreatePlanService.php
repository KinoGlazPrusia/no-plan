<?php
namespace App\Plan\Application;

/* DOMINIO */
use App\Plan\Domain\Plan;

/* APLICACION */
use App\Plan\Application\SaveNewPlanUseCase;
use App\Plan\Application\SaveTimelineStepsUseCase;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Service\Response; // [ ] Eliminar este uso de Response
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
            // Caso de uso para guardar el plan
            $plan = SaveNewPlanUseCase::save(
                $this->repository,
                $title,
                $description,
                $datetime,
                $max_participation,
                $image
            );

            // Caso de uso para guardar el timeline (devuelve el mismo plan pero con el nuevo timeline y lo guarda en el repositorio)
            $plan = SaveTimelineStepsUseCase::save($this->repository, $plan, $timeline);

            Response::json('success', 200, 'Plan created', [$plan]);
            
            // [ ] Implementar caso de uso para asignar categorias al plan
            // [ ] Implementar caso de uso para guardar la imagen del plan en servidor

        } 
        catch (\Exception $e) {
            throw $e;
        }
        
        return $plan;
    }
}   
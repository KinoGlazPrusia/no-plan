<?php
namespace App\Plan\Application;

use Exception;
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanStatus;
use App\Plan\Domain\PlanTimeline;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IService;

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

            // Caso de uso para guardar el timeline (devuelve el mismo plan pero con el nuevo timeline)
           
        } 
        catch (Exception $e) {
            throw $e;
        }
        
        return $plan;
    }
}   
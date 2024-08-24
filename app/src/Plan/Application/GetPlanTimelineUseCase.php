<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanStep;

class GetPlanTimelineUseCase implements IUseCase {
    public static function fetch(
        IRepository $repository,
        Plan $plan
    ) : void {
        try {
            $steps = $repository->findBy('plan_step', 'plan_id', $plan->id);
            foreach ($steps as $step) {
                $plan = self::addStepToPlanTimeline($plan, new PlanStep($step));
            }
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    private static function addStepToPlanTimeline(Plan $plan, PlanStep $step): Plan {
        // Obtiene el timeline del plan
        $timeline = $plan->getTimeline();

        // Añade el nuevo paso serializado a la línea de tiempo
        $timeline[] = $step->serialize();

        // Actualiza el timeline del plan
        $plan->setTimeline($timeline);

        // Retorna el plan actualizado
        return $plan;
    }
}
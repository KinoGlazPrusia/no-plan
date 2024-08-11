<?php
namespace App\Plan\Application;

/* DOMINIO */
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanStep;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class UpdateTimelineStepsUseCase implements IUseCase {
    public static function update(
        IRepository $repository,
        Plan $updatedPlan,
        array $timeline
    ): Plan {
        try {
            // [ ] Esto puede llevar a problemas si después no se actualizan los pasos de la línea de tiempo
            // Revisarlo también en la actualización de categorías
            $repository->deleteWhere('plan_step', 'plan_id', $updatedPlan->id);
            // Itera sobre cada paso y la asocia al plan
            foreach ($timeline as $step) {
                $newStep = new PlanStep((object)$step);
                $newStep->setPlanId($updatedPlan->getId());
                $repository->save($newStep);
                $updatedPlan = self::addStepToTimeline($updatedPlan, $newStep); // Añade el paso al plan
            }

            return $updatedPlan;
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }

    private static function addStepToTimeline(Plan $plan, PlanStep $step): Plan {
        // Obtiene la línea de tiempo actual del plan
        $timeline = $plan->getTimeline();

        // Añade el nuevo paso serializado a la línea de tiempo
        $timeline[] = $step->serialize();

        // Actualiza la línea de tiempo del plan
        $plan->setTimeline($timeline);

        // Retorna el plan actualizado
        return $plan;
    }
}
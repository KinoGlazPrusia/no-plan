<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanStep;

/**
 * Caso de uso para obtener la línea de tiempo de un plan.
 */
class GetPlanTimelineUseCase implements IUseCase {
    /**
     * Obtiene los pasos de la línea de tiempo de un plan y los añade al plan.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @param Plan $plan El plan del cual se obtendrá la línea de tiempo.
     * @return void
     * @throws \Exception Si ocurre algún error durante la operación.
     */
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

    /**
     * Añade un paso a la línea de tiempo de un plan.
     *
     * @param Plan $plan El plan al que se añadirá el paso.
     * @param PlanStep $step El paso a añadir.
     * @return Plan El plan actualizado con el nuevo paso en su línea de tiempo.
     */
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
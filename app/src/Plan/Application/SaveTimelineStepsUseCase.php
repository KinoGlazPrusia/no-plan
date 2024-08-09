<?php
namespace App\Plan\Application;

/* Importaciones del dominio */
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanStep;

/* Importaciones de infraestructura */
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IRepository;

class SaveTimelineStepsUseCase implements IUseCase {
    
    /**
     * Guarda los pasos de la línea de tiempo en el repositorio y los asocia con el plan.
     * 
     * @param IRepository $repository El repositorio donde se guardarán los pasos.
     * @param Plan $plan El plan al que se asociarán los pasos.
     * @param array $timeline Los pasos a guardar.
     * 
     * @return Plan El plan actualizado con los pasos en la línea de tiempo.
     * 
     * @throws \Exception Si ocurre un error durante el guardado.
     */
    public static function save(
        IRepository $repository,
        Plan $plan,
        array $timeline
    ): Plan {
        try {
            // Itera sobre cada paso y realiza las operaciones necesarias
            foreach ($timeline as $step) {
                $step->setPlanId($plan->getId()); // Asocia el paso con el ID del plan
                $repository->save($step); // Guarda el paso en el repositorio
                $plan = self::addStepToTimeline($plan, $step); // Añade el paso al plan
            }
            return $plan; // Retorna el plan actualizado
        } catch (\Exception $e) {
            // Lanza la excepción si algo falla
            throw $e;
        }
    }

    /**
     * Añade el paso a la línea de tiempo del plan.
     * 
     * @param Plan $plan El plan al que se añadirá el paso.
     * @param PlanStep $step El paso a añadir.
     * 
     * @return Plan El plan actualizado con el paso añadido.
     */
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
<?php
namespace App\Plan\Application;

/* DOMINIO */
use App\Plan\Domain\Plan;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IRepository;

/**
 * Caso de uso para actualizar los datos de un plan.
 */
class UpdatePlanDataUseCase {
    /**
     * Actualiza los datos de un plan existente.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @param int|null $id El ID del plan a actualizar.
     * @param string|null $title El nuevo título del plan.
     * @param string|null $description La nueva descripción del plan.
     * @param string|null $datetime La nueva fecha y hora del plan.
     * @param int|null $max_participation El nuevo número máximo de participantes permitidos.
     * @param array|null $image La nueva imagen del plan.
     * @return Plan El plan actualizado.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public static function update(
        IRepository $repository,
        int | null $id,
        string | null $title,
        string | null $description,
        string | null $datetime,
        int | null $max_participation,
        array | null $image
    ): Plan {
        $plan_img_url = $image ? self::generateImagePath($image) : null;
        $planData = self::createPlanData(
            $id, 
            $title, 
            $description, 
            $datetime, 
            $max_participation, 
            $plan_img_url
        );

        try {
            $updatedPlan = new Plan((object)$planData);
            $repository->update($updatedPlan);
            return $updatedPlan;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Crea un arreglo con los datos del plan.
     *
     * @param int|null $id El ID del plan.
     * @param string|null $title El título del plan.
     * @param string|null $description La descripción del plan.
     * @param string|null $datetime La fecha y hora del plan.
     * @param int|null $max_participation El número máximo de participantes.
     * @param string|null $plan_img_url La URL de la imagen del plan.
     * @return array Un arreglo con los datos del plan.
     */
    private static function createPlanData(
        int | null $id,
        string | null $title,
        string | null $description,
        string | null $datetime,
        int | null $max_participation,
        string | null $plan_img_url
    ): array {
        return [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'datetime' => $datetime,
            'max_participation' => $max_participation,
            'plan_img_url' => $plan_img_url
        ];
    }

    /**
     * Genera la ruta de la imagen del plan.
     *
     * @param array $image El array con los datos de la imagen.
     * @return string La ruta generada para la imagen del plan.
     */
    private static function generateImagePath(array $image): string {
        // Extraemos los datos de la imagen y la preparamos para guardarla en servidor una vez creado el usuario
        $extension = explode('/', $image['type'])[1];
        return 'assets/images/plan/' . time() . random_int(0, 1000) . '.' . $extension;
    }
}
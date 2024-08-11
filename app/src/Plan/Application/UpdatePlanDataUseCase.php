<?php
namespace App\Plan\Application;

/* DOMINIO */
use App\Plan\Domain\Plan;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IRepository;

class UpdatePlanDataUseCase {
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

    private static function generateImagePath(array $image): string {
        // Extraemos los datos de la imagen y la preparamos para guardarla en servidor una vez creado el usuario
        $extension = explode('/', $image['type'])[1];
        return 'assets/images/plan/' . time() . random_int(0, 1000) . '.' . $extension;
    }
}
<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Auth\Domain\UUIDv4;
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanStatus;

class SaveNewPlanUseCase {
    public static function save(
        IRepository $repository,
        string $title,
        string $description,
        string $datetime,
        int $max_participation,
        array $image
    ): Plan {

        $uuid = UUIDv4::get();
        $status = $repository->getPlanStatusIdByName(PlanStatus::DRAFT);
        $plan_img_url = self::generateImagePath($image);

        $plan = new Plan(
            (object)[
                'id' => $uuid,
                'title' => $title,
                'description' => $description,
                'datetime' => $datetime,
                'location' => null, // [ ] Implementar más adelante el tema de la geolocalización
                'max_participation' => $max_participation,
                'status' => $status,
                'created_by' => $_SESSION['uid'],
                'plan_img_url' => $plan_img_url
            ]
        );

        $repository->save($plan);

        return $plan;
    }

    private static function generateImagePath(array $image): string {
        // Extraemos los datos de la imagen y la preparamos para guardarla en servidor una vez creado el usuario
        $extension = explode('/', $image['type'])[1];
        return 'assets/images/plan/' . time() . random_int(0, 1000) . '.' . $extension;
    }
}
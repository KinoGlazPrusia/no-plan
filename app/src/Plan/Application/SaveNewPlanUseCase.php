<?php
namespace App\Plan\Application;

/* DOMINIO */
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanStatus;
use App\User\Domain\User;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IRepository;

/**
 * Caso de uso para guardar un nuevo plan en el sistema.
 */
class SaveNewPlanUseCase {
    /**
     * Guarda un nuevo plan en el repositorio.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @param string $title El título del plan.
     * @param string $description La descripción del plan.
     * @param string $datetime La fecha y hora del plan.
     * @param int $max_participation El número máximo de participantes permitidos.
     * @param array $image La imagen del plan.
     * @return Plan El plan creado.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public static function save(
        IRepository $repository,
        string $title,
        string $description,
        string $datetime,
        int $max_participation,
        array $image
    ): Plan {
        // $_SESSION['uid'] = '77ce78e7-69ae-4b3d-9b6f-fc88a11defd5'; // [ ] Eliminar este mock

        $status = $repository->getPlanStatusByName(PlanStatus::PUBLISHED);
        $creator = self::getFilteredCreatorData($repository);

        $plan_img_url = self::generateImagePath($image);
        $plan_data = self::createPlanData(
            $title,
            $description,
            $datetime,
            $max_participation,
            $status,
            $creator,
            $plan_img_url
        );

        try {
            $plan = new Plan((object)$plan_data);
            $planId = $repository->save($plan);
            $plan->setId($planId);
            return $plan;
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene los datos del creador filtrando la información sensible.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @return User El usuario creador con información filtrada.
     */
    private static function getFilteredCreatorData(IRepository $repository): User {
        $creator = $repository->getPlanCreatorById($_SESSION['uid']);
        $serializedCreator = $creator->serialize();

        $filteredData = array_diff_key(
            $serializedCreator,
            array_flip(['email', 'birth_date', 'genre', 'password', 'last_connection'])
        );

        return new User((object)$filteredData);
    }

    /**
     * Crea un array con los datos del plan.
     *
     * @param string $title El título del plan.
     * @param string $description La descripción del plan.
     * @param string $datetime La fecha y hora del plan.
     * @param int $max_participation El número máximo de participantes permitidos.
     * @param mixed $status El objeto de estado del plan.
     * @param User $filteredCreator El creador del plan filtrado.
     * @param string $plan_img_url La URL de la imagen del plan.
     * @return array Un array con los datos del plan.
     */
    private static function createPlanData(
        string $title,
        string $description,
        string $datetime,
        int $max_participation,
        $status,
        $filteredCreator,
        string $plan_img_url
    ): array {
        return [
            'title' => $title,
            'description' => $description,
            'datetime' => $datetime,
            'location' => null, // [ ] Implementar geolocalización más adelante
            'max_participation' => $max_participation,
            'status_id' => $status->id,
            'status' => $status->serialize(),
            'created_by_id' => $_SESSION['uid'],
            'created_by' => $filteredCreator->serialize(false),
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
        // Extraemos los datos de la imagen y la preparamos para guardarla en servidor
        $extension = explode('/', $image['type'])[1];
        return 'assets/images/plan/' . time() . random_int(0, 1000) . '.' . $extension;
    }
}
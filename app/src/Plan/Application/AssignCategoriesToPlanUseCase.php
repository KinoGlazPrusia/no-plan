<?php
namespace App\Plan\Application;

/* DOMINIO */
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanCategory;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IRepository;


class AssignCategoriesToPlanUseCase implements IUseCase {
    public static function assign(
        IRepository $repository,
        Plan $plan,
        array $categories
    ): Plan {
        try {
            // Itera sobre cada paso y realiza las operaciones necesarias
            foreach ($categories as $category) {
                $repository->assignCategoryToPlan($plan, $category); // Guarda el paso en el repositorio
                $plan = self::addCategoryToPlan($plan, $category, $repository); // Añade el paso al plan
            }
            return $plan; // Retorna el plan actualizado
        } catch (\Exception $e) {
            // Lanza la excepción si algo falla
            throw $e;
        }
    }

    private static function addCategoryToPlan(Plan $plan, PlanCategory $category, IRepository $repository): Plan {
        // Obtiene las categorías de la entidad
        $categories = $plan->getCategories();

        // Obtiene los datos del category (solo contamos con el id en este punto)
        $categoryData = $repository->findBy('category', 'id', $category->id)[0];
        $category->setName($categoryData->name);
        $category->setDescription($categoryData->description);

        // Añade el nuevo paso serializado a la línea de tiempo
        $categories[] = $category->serialize();

        // Actualiza las categorías del plan
        $plan->setCategories($categories);

        // Retorna el plan actualizado
        return $plan;
    }
}
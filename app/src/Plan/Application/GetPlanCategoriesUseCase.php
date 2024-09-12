<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanCategory;

/**
 * Caso de uso para obtener las categorías de un plan.
 */
class GetPlanCategoriesUseCase {
    /**
     * Obtiene las categorías de un plan y las añade al plan.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @param Plan $plan El plan al que se añadirán las categorías.
     * @return void
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public static function fetch(IRepository $repository, Plan $plan): void {
        try {
            $categories = $repository->findBy('plan_has_category', 'plan_id', $plan->id);
            foreach ($categories as $category) {
                $plan = self::addCategoryToPlan($plan, new PlanCategory((object)['id' => $category->category_id]), $repository);
            }
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Añade una categoría a un plan.
     *
     * @param Plan $plan El plan al que se añadirá la categoría.
     * @param PlanCategory $category La categoría a añadir.
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @return Plan El plan actualizado con la nueva categoría.
     */
    private static function addCategoryToPlan(Plan $plan, PlanCategory $category, IRepository $repository): Plan {
        // Obtiene las categorías de la entidad
        $categories = $plan->getCategories();

        // Obtiene los datos de la categoría (solo contamos con el id en este punto)
        $categoryData = $repository->findBy('category', 'id', $category->id)[0];
        $category->setName($categoryData->name);
        $category->setDescription($categoryData->description);

        // Añade la nueva categoría serializada
        $categories[] = $category->serialize();

        // Actualiza las categorías del plan
        $plan->setCategories($categories);

        // Retorna el plan actualizado
        return $plan;
    }
}
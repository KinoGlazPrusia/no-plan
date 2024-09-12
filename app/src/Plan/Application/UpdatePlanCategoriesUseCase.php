<?php
namespace App\Plan\Application;

/* DOMINIO */
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanCategory;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

/**
 * Caso de uso para actualizar las categorías de un plan.
 */
class UpdatePlanCategoriesUseCase implements IUseCase {
    /**
     * Actualiza las categorías de un plan.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @param Plan $updatedPlan El plan actualizado con las nuevas categorías.
     * @param array $categories Las categorías a asociar al plan.
     * @return Plan El plan con las categorías actualizadas.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public static function update(
        IRepository $repository,
        Plan $updatedPlan,
        array $categories
    ): Plan {
        try {
            $repository->deleteWhere('plan_has_category', 'plan_id', $updatedPlan->id);
            // Itera sobre cada categoría y la asocia al plan
            foreach ($categories as $category) {
                $repository->assignCategoryToPlan($updatedPlan, (new PlanCategory((object)$category)));
                $updatedPlan = self::addCategoryToPlan($updatedPlan, $category, $repository); // Añade la categoría al plan
            }

            return $updatedPlan;
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Añade una categoría al plan.
     *
     * @param Plan $plan El plan al que se añadirá la categoría.
     * @param PlanCategory $category La categoría a añadir.
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @return Plan El plan actualizado con la nueva categoría añadida.
     */
    private static function addCategoryToPlan(Plan $plan, PlanCategory $category, IRepository $repository): Plan {
        // Obtiene la lista actual de categorías del plan
        $categories = $plan->getCategories();

        // Obtiene los datos de la categoría
        $categoryData = $repository->findBy('category', 'id', $category->id)[0];
        $category->setName($categoryData->name);
        $category->setDescription($categoryData->description);

        // Añade la nueva categoría serializada a la lista de categorías
        $categories[] = $category->serialize();

        // Actualiza las categorías del plan
        $plan->setCategories($categories);

        // Retorna el plan actualizado
        return $plan;
    }
}
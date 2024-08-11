<?php
namespace App\Plan\Application;

/* DOMINIO */
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanCategory;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class UpdatePlanCategoriesUseCase implements IUseCase {
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
                $updatedPlan = self::addCategoryToPlan($updatedPlan, $category, $repository); // Añade el paso al plan
            }

            return $updatedPlan;
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }

    private static function addCategoryToPlan(Plan $plan, PlanCategory $category, IRepository $repository): Plan {
        // Obtiene la línea de tiempo actual del plan
        $categories = $plan->getCategories();

        // Obtiene los datos del category
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
<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanCategory;

class GetPlanCategoriesUseCase {
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
<?php
namespace App\Plan\Application;

/* DOMINIO */
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanCategory;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IRepository;

/**
 * Caso de uso para asignar categorías a un plan.
 */
class AssignCategoriesToPlanUseCase implements IUseCase {
    /**
     * Asigna una lista de categorías a un plan.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @param Plan $plan El plan al que se asignarán las categorías.
     * @param array $categories Un array de objetos PlanCategory que representan las categorías a asignar.
     * @return Plan El plan actualizado con las categorías asignadas.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public static function assign(
        IRepository $repository,
        Plan $plan,
        array $categories
    ): Plan {
        try {
            // Itera sobre cada categoría y realiza las operaciones necesarias
            foreach ($categories as $category) {
                $repository->assignCategoryToPlan($plan, $category); // Guarda la categoría en el repositorio
                $plan = self::addCategoryToPlan($plan, $category, $repository); // Añade la categoría al plan
            }
            return $plan; // Retorna el plan actualizado
        } catch (\Exception $e) {
            // Lanza la excepción si algo falla
            throw $e;
        }
    }

    /**
     * Añade una categoría al plan.
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
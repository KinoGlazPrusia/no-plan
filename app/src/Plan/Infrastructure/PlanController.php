<?php
namespace App\Plan\Infrastructure;

/* DOMINIO */
use App\Plan\Domain\PlanStep;
use App\Plan\Domain\PlanCategory;

/* APLICACION */

/* INFRAESTRUCTURA */

use Exception;
use App\Env;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;


class PlanController {
    public static function create(Request $request, IUseCase | IService $createPlan): void {
        // Validamos la request
        if (!$request->validateQuery([
            'title',
            'description',
            'datetime',
            'max_participation',
            'timeline',
            'categories'
        ])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        // Obtenemos los datos de la request y los sanitizamos
        $title = Sanitizer::sanitizeString($request->query['title']);
        $description = Sanitizer::sanitizeString($request->query['description']);
        $datetime = Sanitizer::sanitizeDate($request->query['datetime']);
        $max_participation = Sanitizer::sanitizeInt($request->query['max_participation']);

        // [ ] Crear instancias de PlanCategory igual que en el timeline
        $categories = array_map(function($category) {
            return Sanitizer::sanitizeString($category);
        }, $request->query['categories']);

        $rawTimeline = $request->query['timeline'];
        $timeline = array_map(function($step) {
            $jsonStep = json_decode($step, true);
            $newStep = new PlanStep((object)$jsonStep);

            return $newStep;
        }, $rawTimeline);

        // Mock de imagen
        $mockImage = array(
            'tmp_name' => Env::PLAN_IMAGES_DIR . 'test-plan-image.png',
            'name' => 'test-plan-image.png',
            'type' => 'image/png',
            'size' => 10000 * 1000,
            'error' => 0
        );

        // Validamos todos los datos recogidos
        $validityMessage = array_merge(
            Validator::validatePlanTitle($title),
            Validator::validatePlanDescription($description),
            Validator::validatePlanDate($datetime),
            Validator::validatePlanParticipation($max_participation),

        );

        if (count($validityMessage) > 0) {
            Response::jsonError(400, implode(', ', $validityMessage));
        }      
        
        try {
            $plan = $createPlan(
                $title, 
                $description, 
                $datetime, 
                $max_participation,
                $categories,
                $timeline,
                $mockImage
            );
            
            Response::json('success', 200, 'Plan created', [$plan]);
        }
        catch (Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function fetchAllCategories(Request $request, IUseCase | IService $fetchAllCategories): void {
        // Validamos la request
        if (!$request->validateQuery([])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        try {
            $categories = $fetchAllCategories();
            Response::json('success', 200, 'Plan categories fetched', $categories);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }

    }
}
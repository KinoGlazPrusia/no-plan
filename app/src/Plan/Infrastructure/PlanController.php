<?php
namespace App\Plan\Infrastructure;

/* DOMINIO */
use App\Plan\Domain\PlanStep;
use App\Plan\Domain\PlanCategory;

/* APLICACION */

/* INFRAESTRUCTURA */
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
            'categories',
            'timeline'
        ])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        // Obtenemos los datos de la request y los sanitizamos
        $title = Sanitizer::sanitizeString($request->query['title']);
        $description = Sanitizer::sanitizeString($request->query['description']);
        $datetime = Sanitizer::sanitizeDate($request->query['datetime']);
        $max_participation = Sanitizer::sanitizeInt($request->query['max_participation']);

        $categories = array_map(function($category) {
            $sanitizedCategory = Sanitizer::sanitizeString($category);
            return new PlanCategory((object)['id' => $sanitizedCategory]);
        }, $request->query['categories']);

        $rawTimeline = $request->query['timeline'];
        $timeline = array_map(function($step) {
            $jsonStep = json_decode($step, true);
            $newStep = new PlanStep((object)$jsonStep);

            return $newStep;
        }, $rawTimeline);

        $image = $_FILES['image'];
        if (!is_uploaded_file($image['tmp_name'])) {
            Response::jsonError(400, 'Invalid image');
        }

        // Validamos todos los datos recogidos
        $validityMessage = array_merge(
            Validator::validatePlanTitle($title),
            Validator::validatePlanDescription($description),
            Validator::validatePlanDate($datetime),
            Validator::validatePlanParticipation($max_participation),
            Validator::validateUploadedImage($image)
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
                $image
            );
            
            Response::json('success', 200, 'Plan created', [$plan]);
        }
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function update(Request $request, IUseCase | IService $updatePlan): void {
        // Validamos la request
        if (!$request->validateQuery(['id'])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        // Obtenemos los datos de la request y los sanitizamos
        try {
            $id = Sanitizer::sanitizeInt($request->query['id']);
            $title = isset($request->query['title']) ? Sanitizer::sanitizeName($request->query['title']) : null;
            $description = isset($request->query['description']) ? Sanitizer::sanitizeString($request->query['description']) : null;
            $datetime = isset($request->query['datetime']) ? Sanitizer::sanitizeDate($request->query['datetime']) : null;
            $max_participation = isset($request->query['max_participation']) ? Sanitizer::sanitizeInt($request->query['max_participation']) : null;

            $categories = isset($request->query['categories']) ? array_map(function($category) {
                $sanitizedCategory = Sanitizer::sanitizeString($category);
                return new PlanCategory((object)['id' => $sanitizedCategory]);
            }, $request->query['categories']) : null;

            $rawTimeline = isset($request->query['timeline']) ? $request->query['timeline'] : null;
            $timeline = $rawTimeline ? array_map(function($step) {
                $jsonStep = json_decode($step, true);
                $newStep = new PlanStep((object)$jsonStep);

                return $newStep;
            }, $rawTimeline) : null;

            $image = isset($_FILES['image']) ? $_FILES['image'] : null;
            if ($image && !is_uploaded_file($image['tmp_name'])) {
                Response::jsonError(400, 'Invalid image');
            }

            // Validamos todos los datos recogidos
            // [ ] Finalizar la implementación de validaciones
            $validityMessage = Validator::validatePlanDate($datetime);

            if (count($validityMessage) > 0) {
                Response::jsonError(400, implode(', ', $validityMessage));
            }

            // Llamamos al caso de uso para actualizar el plan
            if ($updatePlan(
                $id,
                $title,
                $description,
                $datetime,
                $max_participation,
                $categories,
                $timeline,
                $image
            )) Response::json('success', 200, "Plan $id updated");
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function fetchAllPlans(Request $request, IUseCase | IService $fetchAllPlans): void {
        // Validamos la request
        if (!$request->validateQuery(['page', 'items_per_page'])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        // Obtenemos y validamos los datos de la request
        $page = Sanitizer::sanitizeInt($request->query['page']);
        $itemsPerPage = Sanitizer::sanitizeInt($request->query['items_per_page']);

        try {
            $plans = $fetchAllPlans($page, $itemsPerPage);
            Response::json('success', 200, 'All plans', $plans);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function fetchAllCreatedPlans(Request $request, IUseCase | IService $fetchAllCreatedPlans): void {
        // Validamos la request
        if (!$request->validateQuery(['page', 'items_per_page'])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        // Obtenemos y validamos los datos de la request
        $page = Sanitizer::sanitizeInt($request->query['page']);
        $itemsPerPage = Sanitizer::sanitizeInt($request->query['items_per_page']);

        try {
            $plans = $fetchAllCreatedPlans($page, $itemsPerPage);
            Response::json('success', 200, 'All plans', $plans);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function fetchAllAcceptedPlans(Request $request, IUseCase | IService $fetchAllAcceptedPlans): void {
        // Validamos la request
        if (!$request->validateQuery(['page', 'items_per_page'])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        // Obtenemos y validamos los datos de la request
        $page = Sanitizer::sanitizeInt($request->query['page']);
        $itemsPerPage = Sanitizer::sanitizeInt($request->query['items_per_page']);

        try {
            $plans = $fetchAllAcceptedPlans($page, $itemsPerPage);
            Response::json('success', 200, 'All plans', $plans);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function fetchAllRejectedPlans(Request $request, IUseCase | IService $fetchAllRejectedPlans): void {
        // Validamos la request
        if (!$request->validateQuery(['page', 'items_per_page'])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        // Obtenemos y validamos los datos de la request
        $page = Sanitizer::sanitizeInt($request->query['page']);
        $itemsPerPage = Sanitizer::sanitizeInt($request->query['items_per_page']);

        try {
            $plans = $fetchAllRejectedPlans($page, $itemsPerPage);
            Response::json('success', 200, 'All plans', $plans);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function fetchAllPendingPlans(Request $request, IUseCase | IService $fetchAllPendingPlans): void {
        // Validamos la request
        if (!$request->validateQuery(['page', 'items_per_page'])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        // Obtenemos y validamos los datos de la request
        $page = Sanitizer::sanitizeInt($request->query['page']);
        $itemsPerPage = Sanitizer::sanitizeInt($request->query['items_per_page']);

        try {
            $plans = $fetchAllPendingPlans($page, $itemsPerPage);
            Response::json('success', 200, 'All plans', $plans);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function countAllCreatedPlans(Request $request, IUseCase | IService $countAllCreatedPlans): void {
        // Validamos la request
        if (!$request->validateQuery([])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        try {
            $count = $countAllCreatedPlans($_SESSION['uid']);
            Response::json('success', 200, 'All plans count', [$count]);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function countAllNotCreatedPlans(Request $request, IUseCase | IService $countAllNotCreatedPlans): void {
        // Validamos la request
        if (!$request->validateQuery([])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        try {
            $count = $countAllNotCreatedPlans($_SESSION['uid']);
            Response::json('success', 200, 'All plans count', [$count]);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function countAllAcceptedPlans(Request $request, IUseCase | IService $countAllAcceptedPlans): void {
        // Validamos la request
        if (!$request->validateQuery([])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        try {
            $count = $countAllAcceptedPlans($_SESSION['uid']);
            Response::json('success', 200, 'All plans count', [$count]);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function countAllRejectedPlans(Request $request, IUseCase | IService $countAllRejectedPlans): void {
        // Validamos la request
        if (!$request->validateQuery([])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        try {
            $count = $countAllRejectedPlans($_SESSION['uid']);
            Response::json('success', 200, 'All plans count', [$count]);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function countAllPendingPlans(Request $request, IUseCase | IService $countAllPendingPlans): void {
        // Validamos la request
        if (!$request->validateQuery([])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        try {
            $count = $countAllPendingPlans($_SESSION['uid']);
            Response::json('success', 200, 'All plans count', [$count]);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function fetchPlanData(Request $request, IUseCase | IService $fetchPlanData): void {
        // Validamos la request
        if (!$request->validateQuery(['id'])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        // Obtenemos y validamos los datos de la request
        $id = Sanitizer::sanitizeInt($request->query['id']);

        try {
            $plan = $fetchPlanData($id);
            Response::json('success', 200, 'Plan data fetched', [$plan]);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function fetchUserPlans(Request $request, IUseCase | IService $fetchUserPlans): void {
        // Validamos la request
        if (!$request->validateQuery(['user_id'])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
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
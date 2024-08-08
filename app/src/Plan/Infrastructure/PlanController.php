<?php
namespace App\Plan\Infrastructure;

use Exception;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanStep;
use App\Plan\Domain\PlanStatus;

class PlanController {
    public static function create(Request $request, IUseCase | IService $createPlan): void {
        // Validamos la request
        if (!$request->validateQuery([
            'title',
            'description',
            'datetime',
            'max_participation',
            'created_by',
            'timeline'
        ])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        // Obtenemos los datos de la request y los sanitizamos
        $title = Sanitizer::sanitizeString($request->query['title']);
        $description = Sanitizer::sanitizeString($request->query['description']);
        $datetime = Sanitizer::sanitizeDate($request->query['datetime']);
        $max_participation = Sanitizer::sanitizeInt($request->query['max_participation']);
        $created_by = Sanitizer::sanitizeString($request->query['created_by']);

        $rawTimeline = json_decode($request->query['timeline'], true);
        $timeline = array_map(function($step) {
            $newStep = new PlanStep(
                (object)[
                    'title' => Sanitizer::sanitizeString($step['title']),
                    'description' => Sanitizer::sanitizeString($step['description']),
                    'time' => Sanitizer::sanitizeString($step['time'])
                ]
            );
            return $newStep;
        }, $rawTimeline);

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
        
        Response::json('success', 200, 'Plan created', [$request->query]);

        try {
            $plan = $createPlan(
                $title, 
                $description, 
                $datetime, 
                $max_participation,
                $created_by,
                $timeline
            );
            
            Response::json('success', 200, 'Plan created', [$plan]);
        }
        catch (Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }
}
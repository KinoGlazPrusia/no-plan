<?php
namespace App\Participation\Infrastructure;

/* DOMINIO */
use App\Participation\Domain\Participation;
use App\Participation\Domain\ParticipationStatus;

/* APLICACION */

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;


class ParticipationController {
    public static function suscribeToPlan(Request $request, IUseCase | IService $suscribeToPlan): void {
        $request->validateQuery(['plan_id']);
        
        try {
            $planId = Sanitizer::sanitizeInt($request->query['plan_id']);
            $suscribeToPlan($planId);
            Response::json('success', 200, 'Participación solicitada');
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    public static function acceptParticipation(Request $request, IUseCase | IService $acceptParticipation): void {
        $request->validateQuery(['user_id, plan_id']);

        try {
            $userId = Sanitizer::sanitizeString($request->query['user_id']);
            $planId = Sanitizer::sanitizeInt($request->query['plan_id']);
            $acceptParticipation($userId, $planId); 
            Response::json('success', 200, 'Participación aceptada');
        }
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }
}
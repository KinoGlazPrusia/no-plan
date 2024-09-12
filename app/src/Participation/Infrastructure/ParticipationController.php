<?php
namespace App\Participation\Infrastructure;

/* DOMINIO */

/* APLICACION */

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;

/**
 * Controlador para manejar las operaciones relacionadas con las participaciones en planes.
 */
class ParticipationController {
    /**
     * Suscribe al usuario autenticado a un plan.
     *
     * @param Request $request La solicitud HTTP.
     * @param IUseCase|IService $suscribeToPlan Caso de uso o servicio para suscribir al usuario a un plan.
     * @return void
     */
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

    /**
     * Acepta la participación de un usuario en un plan.
     *
     * @param Request $request La solicitud HTTP.
     * @param IUseCase|IService $acceptParticipation Caso de uso o servicio para aceptar la participación.
     * @return void
     */
    public static function acceptParticipation(Request $request, IUseCase | IService $acceptParticipation): void {
        $request->validateQuery(['user_id, participant_id, plan_id']);

        try {
            $userId = Sanitizer::sanitizeString($request->query['user_id']);
            $participantId = Sanitizer::sanitizeString($request->query['participant_id']);
            $planId = Sanitizer::sanitizeInt($request->query['plan_id']);
            $acceptParticipation($userId, $participantId, $planId); 
            Response::json('success', 200, 'Participación aceptada');
        }
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    /**
     * Rechaza la participación de un usuario en un plan.
     *
     * @param Request $request La solicitud HTTP.
     * @param IUseCase|IService $rejectParticipation Caso de uso o servicio para rechazar la participación.
     * @return void
     */
    public static function rejectParticipation(Request $request, IUseCase | IService $rejectParticipation): void {
        $request->validateQuery(['user_id, participant_id, plan_id']);

        try {
            $userId = Sanitizer::sanitizeString($request->query['user_id']);
            $participantId = Sanitizer::sanitizeString($request->query['participant_id']);
            $planId = Sanitizer::sanitizeInt($request->query['plan_id']);
            $rejectParticipation($userId, $participantId, $planId); 
            Response::json('success', 200, 'Participación rechazada');
        }
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    /**
     * Cancela la participación de un usuario en un plan.
     *
     * @param Request $request La solicitud HTTP.
     * @param IUseCase|IService $cancelParticipation Caso de uso o servicio para cancelar la participación.
     * @return void
     */
    public static function cancelParticipation(Request $request, IUseCase | IService $cancelParticipation): void {
        $request->validateQuery(['plan_id']);

        try {
            $planId = Sanitizer::sanitizeInt($request->query['plan_id']);
            $cancelParticipation($planId); 
            Response::json('success', 200, 'Participación cancelada');
        }
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    /**
     * Obtiene todas las participaciones aceptadas en un plan.
     *
     * @param Request $request La solicitud HTTP.
     * @param IUseCase|IService $getAllAcceptedParticipations Caso de uso o servicio para obtener las participaciones aceptadas.
     * @return void
     */
    public static function getAllAcceptedParticipations(Request $request, IUseCase | IService $getAllAcceptedParticipations): void {
        $request->validateQuery(['plan_id']);

        try {
            $planId = Sanitizer::sanitizeInt($request->query['plan_id']);
            $participations = $getAllAcceptedParticipations($planId); 
            Response::json('success', 200, 'Participaciones aceptadas', $participations);
        }
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    /**
     * Obtiene todas las participaciones pendientes en un plan.
     *
     * @param Request $request La solicitud HTTP.
     * @param IUseCase|IService $getAllPendingParticipations Caso de uso o servicio para obtener las participaciones pendientes.
     * @return void
     */
    public static function getAllPendingParticipations(Request $request, IUseCase | IService $getAllPendingParticipations): void {
        $request->validateQuery(['plan_id']);

        try {
            $planId = Sanitizer::sanitizeInt($request->query['plan_id']);
            $participations = $getAllPendingParticipations($planId); 
            Response::json('success', 200, 'Participaciones pendientes', $participations);
        }
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    /**
     * Obtiene todas las participaciones rechazadas en un plan.
     *
     * @param Request $request La solicitud HTTP.
     * @param IUseCase|IService $getAllRejectedParticipations Caso de uso o servicio para obtener las participaciones rechazadas.
     * @return void
     */
    public static function getAllRejectedParticipations(Request $request, IUseCase | IService $getAllRejectedParticipations): void {
        $request->validateQuery(['plan_id']);

        try {
            $planId = Sanitizer::sanitizeInt($request->query['plan_id']);
            $participations = $getAllRejectedParticipations($planId); 
            Response::json('success', 200, 'Participaciones rechazadas', $participations);
        }
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }
}
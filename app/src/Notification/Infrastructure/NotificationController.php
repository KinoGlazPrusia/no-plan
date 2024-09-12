<?php
namespace App\Notification\Infrastructure;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;

/**
 * Controlador para manejar las operaciones relacionadas con las notificaciones.
 */
class NotificationController {
    /**
     * Obtiene las notificaciones no leídas.
     *
     * @param Request $request La solicitud HTTP.
     * @param IUseCase|IService $getUnreadNotifications Caso de uso o servicio para obtener notificaciones no leídas.
     * @return void
     */
    public static function getUnreadNotifications(Request $request, IUseCase | IService $getUnreadNotifications): void {
        $request->validateQuery([]);

        //$_SESSION['uid'] = '77ce78e7-69ae-4b3d-9b6f-fc88a11defd5'; // [ ] Eliminar este mock

        try {
            $unreadNotifications = $getUnreadNotifications($_SESSION['uid']);
            Response::json('success', 200, 'Notificaciones sin leer', $unreadNotifications);
        }
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    /**
     * Marca una notificación como leída.
     *
     * @param Request $request La solicitud HTTP.
     * @param IUseCase|IService $setNotificationAsRead Caso de uso o servicio para marcar una notificación como leída.
     * @return void
     */
    public static function setNotificationAsRead(Request $request, IUseCase | IService $setNotificationAsRead): void {
        $request->validateQuery(['id']);

        $notificationId = Sanitizer::sanitizeInt($request->query['id']);

        try {
            $setNotificationAsRead($notificationId);
            Response::json('success', 200, "Notificación $notificationId marcada como leída");
        }
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }
}
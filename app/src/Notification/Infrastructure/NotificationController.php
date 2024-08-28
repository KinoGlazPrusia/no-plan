<?php
namespace App\Notification\Infrastructure;

/* INFRAESTRUCTURA */
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;

class NotificationController {
    public static function getUnreadNotifications(Request $request, IUseCase | IService $getUnreadNotifications): void {
        $request->validateQuery([]);

        $_SESSION['uid'] = '77ce78e7-69ae-4b3d-9b6f-fc88a11defd5'; // [ ] Eliminar este mock

        try {
            $unreadNotifications = $getUnreadNotifications($_SESSION['uid']);
            Response::json('success', 200, 'Notificaciones sin leer', $unreadNotifications);
        }
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

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
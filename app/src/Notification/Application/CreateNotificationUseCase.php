<?php
namespace App\Notification\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Notification\Domain\Notification;
use App\User\Domain\User;

/**
 * Caso de uso para crear notificaciones.
 */
class CreateNotificationUseCase implements IUseCase {
    /**
     * Crea una nueva notificación.
     *
     * @param IRepository $repository El repositorio para acceder a los datos.
     * @param User $receiver El usuario receptor de la notificación.
     * @param string $notificationType El tipo de notificación.
     * @param string $content El contenido de la notificación.
     * @return void
     * @throws \Exception Si ocurre algún error durante la creación de la notificación.
     */
    public static function create(
        IRepository $repository, 
        User $receiver, 
        string $notificationType, 
        string $content
    ): void {
        
        try {
            $notificationTypeId = $repository->findBy(
                'notification_type', 
                'name', 
                $notificationType
            )[0];
            
            $notificationData = [
                'user_id' => $receiver->id,
                'notification_type_id' => $notificationTypeId->id,
                'content' => $content
            ];

            $newNotification = new Notification((object)$notificationData);
            $repository->save($newNotification);
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
}
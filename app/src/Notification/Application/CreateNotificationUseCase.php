<?php
namespace App\Notification\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Notification\Domain\Notification;
use App\User\Domain\User;

class CreateNotificationUseCase implements IUseCase {
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
<?php
namespace App\Notification\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

use App\User\Domain\User;

class CreateNotificationUseCase implements IUseCase {
    public static function create(IRepository $repository, User $receiver, string $notificationType, string $content) {
        echo "Hola";
        
        $notificationTypeId = $repository->findBy(
            'notification_type', 
            'name', 
            $notificationType
        )[0];
        
        $notificationData = [
            'user_id' => $receiver->id,
            'notification_type' => $notificationTypeId->id,
            'content' => $content
        ];

        echo '<pre>';
        print_r($notificationData);
        echo '</pre>';

        /* $notification = $repository->save(new Notification($notificationData));

        return $notification; */
    }
}
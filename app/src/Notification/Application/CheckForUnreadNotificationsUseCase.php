<?php
namespace App\Notification\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class CheckForUnreadNotificationsUseCase implements IUseCase {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(string $userId): array {
        $unreadNotifications = $this->repository->getUnreadNotificationsByUser($userId);
        
        $unreadNotifications = array_map(function($notification) {
            return $notification->serialize();
        }, $unreadNotifications);

        return $unreadNotifications;
    }
}
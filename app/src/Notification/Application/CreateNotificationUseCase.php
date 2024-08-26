<?php
namespace App\Notification\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class CreateNotificationUseCase implements IUseCase {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(User $receiver, string $notificationType, string $content) {
        $newNotification = 
    }
}
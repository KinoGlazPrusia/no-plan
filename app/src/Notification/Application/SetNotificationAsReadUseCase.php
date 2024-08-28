<?php
namespace App\Notification\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class SetNotificationAsReadUseCase implements IUseCase {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(string $notificationId): void {
        try {
            $this->repository->setNotificationAsRead($notificationId);
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
}
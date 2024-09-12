<?php
namespace App\Notification\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

/**
 * Caso de uso para verificar si hay notificaciones no leídas para un usuario.
 */
class CheckForUnreadNotificationsUseCase implements IUseCase {
    /**
     * @var IRepository El repositorio para acceder a los datos de notificaciones.
     */
    private IRepository $repository;

    /**
     * Constructor de la clase.
     *
     * @param IRepository $repository El repositorio para acceder a los datos de notificaciones.
     */
    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Verifica si hay notificaciones no leídas para un usuario.
     *
     * @param string $userId El ID del usuario.
     * @return array Un array de notificaciones no leídas.
     */
    public function __invoke(string $userId): array {
        $unreadNotifications = $this->repository->getUnreadNotificationsByUser($userId);
        
        $unreadNotifications = array_map(function($notification) {
            return $notification->serialize();
        }, $unreadNotifications);

        return $unreadNotifications;
    }
}
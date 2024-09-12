<?php
namespace App\Notification\Application;

use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

/**
 * Caso de uso para marcar una notificación como leída.
 */
class SetNotificationAsReadUseCase implements IUseCase {
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
     * Marca una notificación como leída.
     *
     * @param string $notificationId El ID de la notificación a marcar como leída.
     * @return void
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public function __invoke(string $notificationId): void {
        try {
            $this->repository->setNotificationAsRead($notificationId);
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
}
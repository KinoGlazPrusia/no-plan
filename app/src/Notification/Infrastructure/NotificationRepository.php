<?php
namespace App\Notification\Infrastructure;

use App\Core\Infrastructure\Repository\CoreRepository;
use App\Notification\Domain\Notification;

/**
 * Repositorio para manejar las operaciones relacionadas con las notificaciones en la base de datos.
 */
class NotificationRepository extends CoreRepository {
    /**
     * Marca una notificación como leída.
     *
     * @param int $notificationId El ID de la notificación a marcar como leída.
     * @return bool Retorna true si la operación fue exitosa, false en caso contrario.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public function setNotificationAsRead(int $notificationId): bool {
        $data = ['notification_id' => $notificationId];

        $sql = "
        UPDATE notification n
        SET n.read = 1
        WHERE n.id = :notification_id
        ";

        try {
            $this->db->connect();
            $this->db->beginTransaction();
            $stmt = $this->db->prepare($sql);
            $this->db->execute($stmt, $data);
            $this->db->commit();
            $this->db->disconnect();
            return true;
        } 
        catch (\Exception $e) {
            $this->db->rollBack();
            $this->db->disconnect();
            throw $e;
        }
    }

    /**
     * Obtiene las notificaciones no leídas para un usuario en específico.
     *
     * @param string $userId El ID del usuario.
     * @return array Un array de objetos Notification que representan las notificaciones no leídas.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public function getUnreadNotificationsByUser(string $userId): array {
        $data = ['user_id' => $userId];

        $sql = "
        SELECT * FROM notification
        WHERE user_id = :user_id
        AND notification.read = 0
        ";
        
        try {
            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $result = $this->db->execute($stmt, $data);
            $this->db->disconnect();

            $unreadNotifications = array_map(function($notification) {
                return new Notification($notification);
            }, $result);

            return $unreadNotifications;
        } 
        catch (\Exception $e) {
            $this->db->disconnect();
            throw $e;
        }
    }
}
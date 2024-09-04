<?php
namespace App\Notification\Infrastructure;

use App\Core\Infrastructure\Repository\CoreRepository;
use App\Notification\Domain\Notification;

class NotificationRepository extends CoreRepository {
    public function setNotificationAsRead(int $notificationId): bool {
        $data = ['notification_id' => $notificationId,];

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
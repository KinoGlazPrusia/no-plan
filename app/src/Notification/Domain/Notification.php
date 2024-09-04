<?php
namespace App\Notification\Domain;

use App\Core\Domain\CoreEntity;

class Notification extends CoreEntity {
    public int | null $id;
    public string | null $user_id;
    public int | null $notification_type_id;
    public string | null $content;
    public string | null $created_at;
    public bool | null $read;

    public function __construct(Object | null $data = null) {
        parent::__construct(
            'notification',
            [
                'id',
                'user_id',
                'notification_type_id',
                'content',
                'created_at',
                'read'
            ]
        );

        $this->id = isset($data->id) ? $data->id : null;
        $this->user_id = isset($data->user_id) ? $data->user_id : null;
        $this->notification_type_id = isset($data->notification_type_id) ? $data->notification_type_id : null;
        $this->content = isset($data->content) ? $data->content : null;
        $this->created_at = isset($data->created_at) ? $data->created_at : null;
        $this->read = isset($data->read) ? $data->read : null;
    }

    /* SETTERS */
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setUserId(int $userId): void {
        $this->user_id = $userId;
    }

    public function setNotificationTypeId(int $notificationTypeId): void {
        $this->notification_type_id = $notificationTypeId;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function setCreatedAt(string $createdAt): void {
        $this->created_at = $createdAt;
    }

    public function setRead(bool $read): void {
        $this->read = $read;
    }

    /* GETTERS */
    public function getId(): int | null {
        return $this->id;
    }

    public function getUserId(): int | null {
        return $this->user_id;
    }

    public function getNotificationTypeId(): int | null {
        return $this->notification_type_id;
    }    

    public function getContent(): string | null {
        return $this->content;
    }

    public function getCreatedAt(): string | null {
        return $this->created_at;
    }

    public function getRead(): bool | null {
        return $this->read;
    }
}
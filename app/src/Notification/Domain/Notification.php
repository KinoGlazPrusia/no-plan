<?php
namespace App\Notification\Domain;

use App\Core\Domain\CoreEntity;

/**
 * Clase Notification que representa una notificación en el dominio.
 */
class Notification extends CoreEntity {
    /**
     * @var int|null ID de la notificación.
     */
    public int | null $id;

    /**
     * @var string|null ID del usuario que recibe la notificación.
     */
    public string | null $user_id;

    /**
     * @var int|null ID del tipo de notificación.
     */
    public int | null $notification_type_id;

    /**
     * @var string|null Contenido de la notificación.
     */
    public string | null $content;

    /**
     * @var string|null Fecha de creación de la notificación.
     */
    public string | null $created_at;

    /**
     * @var bool|null Indica si la notificación ha sido leída.
     */
    public bool | null $read;

    /**
     * Constructor de la clase.
     *
     * @param object|null $data Datos para inicializar la notificación.
     */
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

    /**
     * Establece el ID de la notificación.
     *
     * @param int $id El ID de la notificación.
     * @return void
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Establece el ID del usuario receptor.
     *
     * @param int $userId El ID del usuario.
     * @return void
     */
    public function setUserId(int $userId): void {
        $this->user_id = $userId;
    }

    /**
     * Establece el ID del tipo de notificación.
     *
     * @param int $notificationTypeId El ID del tipo de notificación.
     * @return void
     */
    public function setNotificationTypeId(int $notificationTypeId): void {
        $this->notification_type_id = $notificationTypeId;
    }

    /**
     * Establece el contenido de la notificación.
     *
     * @param string $content El contenido de la notificación.
     * @return void
     */
    public function setContent(string $content): void {
        $this->content = $content;
    }

    /**
     * Establece la fecha de creación de la notificación.
     *
     * @param string $createdAt La fecha de creación.
     * @return void
     */
    public function setCreatedAt(string $createdAt): void {
        $this->created_at = $createdAt;
    }

    /**
     * Establece si la notificación ha sido leída.
     *
     * @param bool $read El estado de lectura.
     * @return void
     */
    public function setRead(bool $read): void {
        $this->read = $read;
    }

    /* GETTERS */

    /**
     * Obtiene el ID de la notificación.
     *
     * @return int|null El ID de la notificación.
     */
    public function getId(): int | null {
        return $this->id;
    }

    /**
     * Obtiene el ID del usuario receptor.
     *
     * @return int|null El ID del usuario.
     */
    public function getUserId(): int | null {
        return $this->user_id;
    }

    /**
     * Obtiene el ID del tipo de notificación.
     *
     * @return int|null El ID del tipo de notificación.
     */
    public function getNotificationTypeId(): int | null {
        return $this->notification_type_id;
    }    

    /**
     * Obtiene el contenido de la notificación.
     *
     * @return string|null El contenido de la notificación.
     */
    public function getContent(): string | null {
        return $this->content;
    }

    /**
     * Obtiene la fecha de creación de la notificación.
     *
     * @return string|null La fecha de creación.
     */
    public function getCreatedAt(): string | null {
        return $this->created_at;
    }

    /**
     * Obtiene el estado de lectura de la notificación.
     *
     * @return bool|null El estado de lectura.
     */
    public function getRead(): bool | null {
        return $this->read;
    }
}
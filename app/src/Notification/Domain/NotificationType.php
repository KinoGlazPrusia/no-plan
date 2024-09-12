<?php
namespace App\Notification\Domain;

use App\Core\Domain\CoreEntity;

/**
 * Clase NotificationType que representa el tipo de notificación en el dominio.
 */
class NotificationType extends CoreEntity {
    /**
     * Constantes para cada tipo de notificación.
     */
    const MESSAGE = 'message';
    const PARTICIPATION_REQUEST = 'participation_request';
    const PARTICIPATION_ACCEPTED = 'participation_accepted';
    const PARTICIPATION_REJECTED = 'participation_rejected';
    const PARTICIPATION_CANCELLED = 'participation_cancelled';
    const PLAN_RATED = 'plan_rated';
    const RATED = 'rated';
    const FOLLOWED = 'followed';
    const INFO = 'info';

    /**
     * @var int|null ID del tipo de notificación.
     */
    public readonly int | null $id;

    /**
     * @var string|null Nombre del tipo de notificación.
     */
    public readonly string | null $name;

    /**
     * Constructor de la clase.
     *
     * @param object|null $data Datos para inicializar el tipo de notificación.
     */
    public function __construct(Object | null $data = null) {
        parent::__construct([
            'notification_type',
            [
                'id',
                'name'
            ]
        ]);

        $this->id = isset($data->id) ? $data->id : null;
        $this->name = isset($data->name) ? $data->name : null;
    }

    /**
     * Obtiene una lista de valores válidos para los tipos de notificación.
     *
     * @return array Un array de valores válidos para los tipos de notificación.
     */
    public static function getValidValues() {
        return [
            self::MESSAGE,
            self::PARTICIPATION_REQUEST,
            self::PARTICIPATION_ACCEPTED,
            self::PARTICIPATION_REJECTED,
            self::PARTICIPATION_CANCELLED,
            self::PLAN_RATED,
            self::RATED,
            self::FOLLOWED
        ];
    }

    /* SETTERS */

    /**
     * Establece el ID del tipo de notificación.
     *
     * @param int $id El ID del tipo de notificación.
     * @return void
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Establece el nombre del tipo de notificación.
     *
     * @param string $name El nombre del tipo de notificación.
     * @return void
     */
    public function setName(string $name): void {
        $this->name = $name;
    }
}
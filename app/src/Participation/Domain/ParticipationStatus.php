<?php
namespace App\Participation\Domain;

use App\Core\Domain\CoreEntity;

/**
 * Clase ParticipationStatus que representa el estado de una participación en el dominio.
 * Este value object se inicializa con el valor de una de las constantes de la clase ParticipationStatus.
 * Por ejemplo: new ParticipationStatus(ParticipationStatus::PENDING)
 */
class ParticipationStatus extends CoreEntity {
    /**
     * Constantes para cada estado de participación.
     */
    const PENDING = 'pending';
    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';
    const CANCELLED = 'cancelled';

    /**
     * @var int|null ID del estado de la participación.
     */
    public readonly int | null $id;

    /**
     * @var string|null Estado de la participación.
     */
    public readonly string | null $status;

    /**
     * Constructor de la clase.
     *
     * @param object|null $data Datos para inicializar el estado de la participación.
     */
    public function __construct(Object | null $data = null) {
        parent::__construct(
            'participation_status',
            [
                'id',
                'status',
            ]
        );

        $this->id = isset($data->id) ? $data->id : null;
        $this->status = isset($data->status) ? $data->status : null;
    }

    /**
     * Obtiene una lista de valores válidos para los estados de participación.
     *
     * @return array Un array de valores válidos para los estados de participación.
     */
    public static function getValidValues() {
        return [
            self::PENDING,
            self::ACCEPTED,
            self::REJECTED,
            self::CANCELLED,
        ];
    }

    /* SETTERS */

    /**
     * Establece el ID del estado de la participación.
     *
     * @param int $id El ID del estado de la participación.
     * @return void
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Establece el estado de la participación.
     *
     * @param string $status El estado de la participación.
     * @return void
     */
    public function setStatus(string $status): void {
        $this->status = $status;
    }

    /* GETTERS */

    /**
     * Obtiene el ID del estado de la participación.
     *
     * @return int|null El ID del estado de la participación.
     */
    public function getId(): int | null {
        return $this->id;
    }

    /**
     * Obtiene el estado de la participación.
     *
     * @return string|null El estado de la participación.
     */
    public function getStatus(): string | null {
        return $this->status;
    }
}
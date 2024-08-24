<?php
namespace App\Participation\Domain;

use App\Core\Domain\CoreEntity;

/* Value Object */
/* Este value object se inicializa con el valor de una de las constantes de la clase ParticipationStatus
Con lo que la propia clase ya contiene todos los valores posibles
Por ejemplo: new ParticipationStatus(ParticipationStatus::PENDING)  */
class ParticipationStatus extends CoreEntity {
    const PENDING = 'pending';
    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';
    const CANCELLED = 'cancelled';

    public readonly int | null $id;
    public readonly string | null $status;

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

    public static function getValidValues() {
        return [
            self::PENDING,
            self::ACCEPTED,
            self::REJECTED,
            self::CANCELLED,
        ];
    }

    /* SETTERS */
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    /* GETTERS */
    public function getId(): int | null {
        return $this->id;
    }

    public function getStatus(): string | null {
        return $this->status;
    }
}
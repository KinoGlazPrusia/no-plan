<?php
namespace App\Plan\Domain;

use App\Core\Domain\CoreEntity;

/* Value Object */
/* Este value object se inicializa con el valor de una de las constantes de la clase PlanStatus.
   Con lo que la propia clase ya contiene todos los valores posibles.
   Por ejemplo: new PlanStatus(PlanStatus::DRAFT) */
   
/**
 * Clase PlanStatus que representa el estado de un plan en el dominio.
 */
class PlanStatus extends CoreEntity {
    // Constantes que representan los diferentes estados de un plan.
    const DRAFT = 'draft';
    const PUBLISHED = 'published';
    const OPEN = 'open';
    const CLOSED = 'closed';
    const IN_PROGRESS = 'in_progress';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';
    const POSTPONED = 'postponed';
    const FULL = 'full';
    const PENDING_APPROVAL = 'pending_approval';
    const PRIVATE = 'private';
    const PUBLIC = 'public';
    const ENDED = 'ended';
    const UNDER_REVIEW = 'under_review';
    const ARCHIVED = 'archived';

    /**
     * @var int|null El ID del estado del plan.
     */
    public readonly int | null $id;

    /**
     * @var string|null El estado del plan.
     */
    public readonly string | null $status;

    /**
     * Constructor de la clase.
     *
     * @param object|null $data Datos para inicializar el estado del plan.
     */
    public function __construct(Object | null $data = null) {
        parent::__construct(
            'plan_status',
            [
                'id',
                'status',
            ]
        );

        $this->id = isset($data->id) ? $data->id : null;
        $this->status = isset($data->status) ? $data->status : null;
    }

    /**
     * Obtiene una lista de valores válidos para los estados de un plan.
     *
     * @return array Un array de valores válidos para los estados de un plan.
     */
    public static function getValidValues() {
        return [
            self::DRAFT,
            self::PUBLISHED,
            self::OPEN,
            self::CLOSED,
            self::IN_PROGRESS,
            self::COMPLETED,
            self::CANCELLED,
            self::POSTPONED,
            self::FULL,
            self::PENDING_APPROVAL,
            self::PRIVATE,
            self::PUBLIC,
            self::ENDED,
            self::UNDER_REVIEW,
            self::ARCHIVED,
        ];
    }

    /* SETTERS */

    /**
     * Establece el ID del estado del plan.
     *
     * @param int $id El ID del estado del plan.
     * @return void
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Establece el estado del plan.
     *
     * @param string $status El estado del plan.
     * @return void
     */
    public function setStatus(string $status): void {
        $this->status = $status;
    }
}
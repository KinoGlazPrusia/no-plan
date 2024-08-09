<?php
namespace App\Plan\Domain;

use App\Core\Domain\CoreEntity;

/* Value Object */
/* Este value object se inicializa con el valor de una de las constantes de la clase PlanStatus
Con lo que la propia clase ya contiene todos los valores posibles
Por ejemplo: new PlanStatus(PlanStatus::DRAFT)  */
class PlanStatus extends CoreEntity {
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

    public readonly int | null $id;
    public readonly string | null $status;

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
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }
}
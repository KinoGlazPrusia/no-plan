<?php
namespace App\Notification\Domain;

use App\Core\Domain\CoreEntity;

class NotificationType extends CoreEntity {
    const MESSAGE = 'message';
    const PARTICIPATION_REQUEST = 'participation_request';
    const PARTICIPATION_ACCEPTED = 'participation_accepted';
    const PARTICIPATION_REJECTED = 'participation_rejected';
    const PARTICIPATION_CANCELLED = 'participation_cancelled';
    const PLAN_RATED = 'plan_rated';
    const RATED = 'rated';
    const FOLLOWED = 'followed';

    public readonly int | null $id;
    public readonly string | null $name;

    public function __construct(Object | null $data = null) {
        parent::construct([
            'notification_type',
            [
                'id',
                'name'
            ]
        ]);

        $this->id = isset($data->id) ? $data->id : null;
        $this->name = isset($data->name) ? $data->name : null;
    }

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
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }
}
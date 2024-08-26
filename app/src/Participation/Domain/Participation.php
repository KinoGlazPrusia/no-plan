<?php
namespace App\Participation\Domain;

use App\Core\Domain\CoreEntity;

class Participation extends CoreEntity {
    public int | null $id;
    public int | null $plan_id;
    public string | null $user_id;
    public int | null $status_id;

    public function __construct(Object | null $data = null) {
        parent::__construct(
            'participation',
            [
                'id',
                'user_id',
                'plan_id',
                'status_id'
            ]
        );

        $this->id = isset($data->id) ? $data->id : null;
        $this->plan_id = isset($data->plan_id) ? $data->plan_id : null;
        $this->user_id = isset($data->user_id) ? $data->user_id : null;
        $this->status_id = isset($data->status_id) ? $data->status_id : null;
    }

    /* SETTERS */
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setPlanId(int $planId): void {
        $this->plan_id = $planId;
    }

    public function setUserId(int $userId): void {
        $this->user_id = $userId;
    }

    public function setStatusId(int $statusId): void {
        $this->status_id = $statusId;
    }

    /* GETTERS */
    public function getId(): int | null {
        return $this->id;
    }

    public function getPlanId(): int | null {
        return $this->plan_id;
    }

    public function getUserId(): int | null {
        return $this->user_id;
    }

    public function getStatusId(): int | null {
        return $this->status_id;
    }
}
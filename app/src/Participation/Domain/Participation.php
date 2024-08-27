<?php
namespace App\Participation\Domain;

use App\Core\Domain\CoreEntity;
use App\Plan\Domain\Plan;
use App\User\Domain\User;

class Participation extends CoreEntity {
    public int | null $plan_id;
    public string | null $user_id;
    public array | null $userData;
    public int | null $status_id;
    public string | null $status;

    public function __construct(Object | null $data = null) {
        parent::__construct(
            'participation',
            [
                'user_id',
                'plan_id',
                'status_id'
            ]
        );

        $this->plan_id = isset($data->plan_id) ? $data->plan_id : null;
        $this->user_id = isset($data->user_id) ? $data->user_id : null;
        $this->status_id = isset($data->status_id) ? $data->status_id : null;
        $this->userData = isset($data->user) ? $data->user : null;
        $this->status = isset($data->status) ? $data->status : null;
    }

    /* SETTERS */
    public function setPlanId(int $planId): void {
        $this->plan_id = $planId;
    }

    public function setUserId(string $userId): void {
        $this->user_id = $userId;
    }

    public function setStatusId(int $statusId): void {
        $this->status_id = $statusId;
    }

    public function setUserData(array $userData): void {
        $this->userData = $userData;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    /* GETTERS */
    public function getPlanId(): int | null {
        return $this->plan_id;
    }

    public function getUserId(): string | null {
        return $this->user_id;
    }

    public function getStatusId(): int | null {
        return $this->status_id;
    }

    public function getUserData(): array | null {
        return $this->userData;
    }

    public function getStatus(): string | null {
        return $this->status;
    }
}
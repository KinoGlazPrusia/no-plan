<?php
namespace App\Plan\Domain;

use App\Core\Domain\CoreEntity;
use App\User\Domain\User;
use App\Plan\Domain\PlanStatus;
use App\Plan\Domain\PlanTimeline;

class Plan extends CoreEntity {

    public readonly int | null $id;
    public readonly string | null $title;
    public readonly string | null $description;
    public readonly string | null $datetime;
    public readonly string | null $location;
    public readonly int $max_participation;
    public readonly int | null $status_id;
    public readonly PlanStatus | null $status;
    public readonly string | null $created_by_id;
    public readonly User | null $created_by;
    public readonly string | null $plan_img_url;
    public readonly array | null $timeline;

    public function __construct(Object | null $data = null) {
        parent::__construct(
            'plan',
            [
                'id',
                'title',
                'description',
                'datetime',
                'location',
                'max_participation',
                'status_id',
                'created_by_id',
                'plan_img_url'
            ]
        );

        $this->id = isset($data->id) ? $data->id : null;
        $this->title = isset($data->title) ? $data->title : null;
        $this->description = isset($data->description) ? $data->description : null;
        $this->datetime = isset($data->datetime) ? $data->datetime : null;
        $this->location = isset($data->location) ? $data->location : null;
        $this->max_participation = isset($data->max_participation) ? $data->max_participation : null;
        $this->status_id = isset($data->status_id) ? $data->status_id : null;
        $this->status = isset($data->status) ? $data->status : null;
        $this->created_by_id = isset($data->created_by_id) ? $data->created_by_id : null;
        $this->created_by = isset($data->created_by) ? $data->created_by : null;
        $this->plan_img_url = isset($data->plan_img_url) ? $data->plan_img_url : null;
        $this->timeline = isset($data->timeline) ? $data->timeline : null;
    }

    /* SETTERS */
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setDatetime(string $datetime): void {
        $this->datetime = $datetime;
    }

    public function setLocation(string $location): void {
        $this->location = $location;
    }

    public function setMaxParticipation(int $max_participation): void {
        $this->max_participation = $max_participation;
    }

    public function setStatus(int $statusId): void {
        $this->status_id = $statusId;
    }

    public function setCreatedBy(string $userId): void {
        $this->created_by_id = $userId;
    }

    public function setTimeline(array $timeline): void {
        // Esta función espera un array de PlanStep
        $this->timeline = $timeline;
    }
}
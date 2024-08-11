<?php
namespace App\Plan\Domain;

use App\Core\Domain\CoreEntity;
use App\User\Domain\User;
use App\Plan\Domain\PlanStatus;
use App\Plan\Domain\PlanTimeline;

class Plan extends CoreEntity {

    public int | null $id;
    public string | null $title;
    public string | null $description;
    public string | null $datetime;
    public string | null $location;
    public int | null $max_participation;
    public int | null $status_id;
    public array | null $status;
    public string | null $created_by_id;
    public array | null $created_by;
    public string | null $plan_img_url;
    public array | null $timeline;
    public array | null $categories;

    // Se le pasa un objeto con los datos para no tener que pasar todos los parámetros al constructor, ya que no se poueden pasar de manera desordenada
    // De este modo solo se pasan los datos que se necesitan
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
        $this->categories = isset($data->categories) ? $data->categories : null;
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

    public function setCategories(array $categories): void {
        // Esta función espera un array de PlanCategory
        $this->categories = $categories;
    }

    /* GETTERS */
    public function getId(): int | null {
        return $this->id;
    }

    public function getTitle(): string | null  {
        return $this->title;
    }

    public function getDescription(): string | null  {
        return $this->description;
    }

    public function getDatetime(): string | null  {
        return $this->datetime;
    }

    public function getLocation(): string | null  {
        return $this->location;
    }

    public function getMaxParticipation(): int | null  {
        return $this->max_participation;
    }

    public function getStatusId(): int | null  {
        return $this->status_id;
    }

    public function getStatus(): array | null  {
        return $this->status;
    }

    public function getCreatedById(): string | null  {
        return $this->created_by_id;
    }

    public function getCreatedBy(): array | null  {
        return $this->created_by;
    }

    public function getPlanImgUrl(): string | null {
        return $this->plan_img_url;
    }

    public function getTimeline(): array | null  {
        return $this->timeline;
    }

    public function getCategories(): array | null  {
        return $this->categories;
    }
}
<?php
namespace App\Plan\Domain;

use App\Core\Domain\CoreEntity;

class PlanStep extends CoreEntity {

    public int | null $id;
    public int | null $plan_id;
    public string | null $title;
    public string | null $description;
    public string | null $time;

    public function __construct(Object | null $data = null) {
        parent::__construct(
            'plan_step',
            [
                'id',
                'plan_id',
                'title',
                'description',
                'time'
            ]
        );

        $this->id = isset($data->id) ? $data->id : null;
        $this->plan_id = isset($data->plan_id) ? $data->plan_id : null;
        $this->title = isset($data->title) ? $data->title : null;
        $this->description = isset($data->description) ? $data->description : null;
        $this->time = isset($data->time) ? $data->time : null;
    }

    /* SETTERS */
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setPlanId(int $plan_id): void {	
        $this->plan_id = $plan_id;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setTime(string $time): void {
        $this->time = $time;
    }

    /* GETTERS */
    public function getId(): int | null {
        return $this->id;
    }

    public function getPlanId(): int | null {
        return $this->plan_id;
    }

    public function getTitle(): string | null  {
        return $this->title;
    }

    public function getDescription(): string | null  {
        return $this->description;
    }

    public function getTime(): string | null  {
        return $this->time;
    }
}
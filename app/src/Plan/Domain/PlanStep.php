<?php
namespace App\Plan\Domain;

use App\Core\Domain\CoreEntity;

class PlanStep extends CoreEntity {

    public readonly int | null $id;
    public readonly string | null $title;
    public readonly string | null $description;
    public readonly string | null $time;

    public function __construct(Object | null $data = null) {
        parent::__construct(
            'plan_step',
            [
                'id',
                'title',
                'description',
                'time'
            ]
        );

        $this->id = isset($data->id) ? $data->id : null;
        $this->title = isset($data->title) ? $data->title : null;
        $this->description = isset($data->description) ? $data->description : null;
        $this->time = isset($data->time) ? $data->time : null;
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

    public function setTime(string $time): void {
        $this->time = $time;
    }
}
<?php
namespace App\Plan\Domain;

use App\Core\Domain\CoreEntity;

class PlanCategory extends CoreEntity {
    public int | null $id;
    public string | null $name;
    public string | null $description;

    public function __construct(Object | null $data = null) {
        parent::__construct(
            'plan_category',
            [
                'id',
                'name',
                'description',
            ]
        );

        $this->id = isset($data->id) ? $data->id : null;
        $this->name = isset($data->name) ? $data->name : null;
        $this->description = isset($data->description) ? $data->description : null;
    }

    /* SETTERS */
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }
}
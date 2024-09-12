<?php
namespace App\Plan\Domain;

use App\Core\Domain\CoreEntity;

/**
 * Clase PlanCategory que representa una categoría de plan en el dominio.
 */
class PlanCategory extends CoreEntity {
    /**
     * @var int|null El ID de la categoría del plan.
     */
    public int | null $id;

    /**
     * @var string|null El nombre de la categoría del plan.
     */
    public string | null $name;

    /**
     * @var string|null La descripción de la categoría del plan.
     */
    public string | null $description;

    /**
     * Constructor de la clase.
     *
     * @param object|null $data Datos para inicializar la categoría del plan.
     */
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

    /**
     * Establece el ID de la categoría del plan.
     *
     * @param int $id El ID de la categoría.
     * @return void
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Establece el nombre de la categoría del plan.
     *
     * @param string $name El nombre de la categoría.
     * @return void
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * Establece la descripción de la categoría del plan.
     *
     * @param string $description La descripción de la categoría.
     * @return void
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }
}
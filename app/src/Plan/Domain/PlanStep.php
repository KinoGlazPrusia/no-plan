<?php
namespace App\Plan\Domain;

use App\Core\Domain\CoreEntity;

/**
 * Clase PlanStep que representa un paso en la línea de tiempo de un plan.
 */
class PlanStep extends CoreEntity {

    /**
     * @var int|null El ID del paso.
     */
    public int | null $id;

    /**
     * @var int|null El ID del plan al que pertenece el paso.
     */
    public int | null $plan_id;

    /**
     * @var string|null El título del paso.
     */
    public string | null $title;

    /**
     * @var string|null La descripción del paso.
     */
    public string | null $description;

    /**
     * @var string|null La duración o tiempo asociado con el paso.
     */
    public string | null $time;

    /**
     * Constructor de la clase.
     *
     * @param object|null $data Datos para inicializar el paso.
     */
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

    /**
     * Establece el ID del paso.
     *
     * @param int $id El ID del paso.
     * @return void
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Establece el ID del plan asociado.
     *
     * @param int $plan_id El ID del plan.
     * @return void
     */
    public function setPlanId(int $plan_id): void {	
        $this->plan_id = $plan_id;
    }

    /**
     * Establece el título del paso.
     *
     * @param string $title El título del paso.
     * @return void
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * Establece la descripción del paso.
     *
     * @param string $description La descripción del paso.
     * @return void
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * Establece el tiempo asociado con el paso.
     *
     * @param string $time La duración o tiempo del paso.
     * @return void
     */
    public function setTime(string $time): void {
        $this->time = $time;
    }

    /* GETTERS */

    /**
     * Obtiene el ID del paso.
     *
     * @return int|null El ID del paso.
     */
    public function getId(): int | null {
        return $this->id;
    }

    /**
     * Obtiene el ID del plan asociado.
     *
     * @return int|null El ID del plan.
     */
    public function getPlanId(): int | null {
        return $this->plan_id;
    }

    /**
     * Obtiene el título del paso.
     *
     * @return string|null El título del paso.
     */
    public function getTitle(): string | null  {
        return $this->title;
    }

    /**
     * Obtiene la descripción del paso.
     *
     * @return string|null La descripción del paso.
     */
    public function getDescription(): string | null  {
        return $this->description;
    }

    /**
     * Obtiene el tiempo asociado con el paso.
     *
     * @return string|null El tiempo del paso.
     */
    public function getTime(): string | null  {
        return $this->time;
    }
}
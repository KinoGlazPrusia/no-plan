<?php
namespace App\Plan\Domain;

use App\Core\Domain\CoreEntity;
use App\User\Domain\User;
use App\Plan\Domain\PlanStatus;
use App\Plan\Domain\PlanTimeline;

/**
 * Clase Plan que representa un plan en el dominio.
 */
class Plan extends CoreEntity {

    /**
     * @var int|null El ID del plan.
     */
    public int | null $id;

    /**
     * @var string|null El título del plan.
     */
    public string | null $title;

    /**
     * @var string|null La descripción del plan.
     */
    public string | null $description;

    /**
     * @var string|null La fecha y hora del plan.
     */
    public string | null $datetime;

    /**
     * @var string|null La ubicación del plan.
     */
    public string | null $location;

    /**
     * @var int|null El número máximo de participantes permitidos.
     */
    public int | null $max_participation;

    /**
     * @var int|null El ID del estado del plan.
     */
    public int | null $status_id;

    /**
     * @var array|null El estado del plan.
     */
    public array | null $status;

    /**
     * @var string|null El ID del creador del plan.
     */
    public string | null $created_by_id;

    /**
     * @var array|null Los datos del creador del plan.
     */
    public array | null $created_by;

    /**
     * @var string|null La URL de la imagen del plan.
     */
    public string | null $plan_img_url;

    /**
     * @var array|null La línea de tiempo del plan.
     */
    public array | null $timeline;

    /**
     * @var array|null Las categorías del plan.
     */
    public array | null $categories;

    /**
     * Constructor de la clase.
     *
     * @param object|null $data Datos para inicializar el plan.
     */
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

    /**
     * Establece el ID del plan.
     *
     * @param int $id El ID del plan.
     * @return void
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Establece el título del plan.
     *
     * @param string $title El título del plan.
     * @return void
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * Establece la descripción del plan.
     *
     * @param string $description La descripción del plan.
     * @return void
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * Establece la fecha y hora del plan.
     *
     * @param string $datetime La fecha y hora del plan.
     * @return void
     */
    public function setDatetime(string $datetime): void {
        $this->datetime = $datetime;
    }

    /**
     * Establece la ubicación del plan.
     *
     * @param string $location La ubicación del plan.
     * @return void
     */
    public function setLocation(string $location): void {
        $this->location = $location;
    }

    /**
     * Establece el número máximo de participantes permitidos.
     *
     * @param int $max_participation El número máximo de participantes.
     * @return void
     */
    public function setMaxParticipation(int $max_participation): void {
        $this->max_participation = $max_participation;
    }

    /**
     * Establece el ID del estado del plan.
     *
     * @param int $statusId El ID del estado del plan.
     * @return void
     */
    public function setStatusId(int $statusId): void {
        $this->status_id = $statusId;
    }

    /**
     * Establece el estado del plan.
     *
     * @param array $status El estado del plan.
     * @return void
     */
    public function setStatus(array $status): void {        
        $this->status = $status;
    }

    /**
     * Establece el ID del creador del plan.
     *
     * @param string $userId El ID del creador del plan.
     * @return void
     */
    public function setCreatedById(string $userId): void {
        $this->created_by_id = $userId;
    }

    /**
     * Establece los datos del creador del plan.
     *
     * @param array $userData Los datos del creador.
     * @return void
     */
    public function setCreatedBy(array $userData): void {
        $this->created_by = $userData;
    }

    /**
     * Establece la línea de tiempo del plan.
     *
     * @param array $timeline La línea de tiempo que se va a establecer.
     * @return void
     */
    public function setTimeline(array $timeline): void {
        // Esta función espera un array de PlanStep
        $this->timeline = $timeline;
    }

    /**
     * Establece las categorías del plan.
     *
     * @param array $categories Las categorías que se van a establecer.
     * @return void
     */
    public function setCategories(array $categories): void {
        // Esta función espera un array de PlanCategory
        $this->categories = $categories;
    }

    /* GETTERS */

    /**
     * Obtiene el ID del plan.
     *
     * @return int|null El ID del plan.
     */
    public function getId(): int | null {
        return $this->id;
    }

    /**
     * Obtiene el título del plan.
     *
     * @return string|null El título del plan.
     */
    public function getTitle(): string | null  {
        return $this->title;
    }

    /**
     * Obtiene la descripción del plan.
     *
     * @return string|null La descripción del plan.
     */
    public function getDescription(): string | null  {
        return $this->description;
    }

    /**
     * Obtiene la fecha y hora del plan.
     *
     * @return string|null La fecha y hora del plan.
     */
    public function getDatetime(): string | null  {
        return $this->datetime;
    }

    /**
     * Obtiene la ubicación del plan.
     *
     * @return string|null La ubicación del plan.
     */
    public function getLocation(): string | null  {
        return $this->location;
    }

    /**
     * Obtiene el número máximo de participantes permitidos.
     *
     * @return int|null El número máximo de participantes.
     */
    public function getMaxParticipation(): int | null  {
        return $this->max_participation;
    }

    /**
     * Obtiene el ID del estado del plan.
     *
     * @return int|null El ID del estado del plan.
     */
    public function getStatusId(): int | null  {
        return $this->status_id;
    }

    /**
     * Obtiene el estado del plan.
     *
     * @return array|null El estado del plan.
     */
    public function getStatus(): array | null  {
        return $this->status;
    }

    /**
     * Obtiene el ID del creador del plan.
     *
     * @return string|null El ID del creador del plan.
     */
    public function getCreatedById(): string | null  {
        return $this->created_by_id;
    }

    /**
     * Obtiene los datos del creador del plan.
     *
     * @return array|null Los datos del creador.
     */
    public function getCreatedBy(): array | null  {
        return $this->created_by;
    }

    /**
     * Obtiene la URL de la imagen del plan.
     *
     * @return string|null La URL de la imagen del plan.
     */
    public function getPlanImgUrl(): string | null {
        return $this->plan_img_url;
    }

    /**
     * Obtiene la línea de tiempo del plan.
     *
     * @return array|null La línea de tiempo del plan.
     */
    public function getTimeline(): array | null  {
        return $this->timeline;
    }

    /**
     * Obtiene las categorías del plan.
     *
     * @return array|null Las categorías del plan.
     */
    public function getCategories(): array | null  {
        return $this->categories;
    }
}
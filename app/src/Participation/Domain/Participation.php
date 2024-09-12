<?php
namespace App\Participation\Domain;

use App\Core\Domain\CoreEntity;
use App\Plan\Domain\Plan;
use App\User\Domain\User;

/**
 * Clase Participation que representa una participación en un plan.
 */
class Participation extends CoreEntity {
    /**
     * @var int|null ID del plan en el que se participa.
     */
    public int | null $plan_id;

    /**
     * @var string|null ID del usuario que participa en el plan.
     */
    public string | null $user_id;

    /**
     * @var array|null Datos del usuario que participa en el plan.
     */
    public array | null $userData;

    /**
     * @var int|null ID del estado de la participación.
     */
    public int | null $status_id;

    /**
     * @var string|null Estado de la participación.
     */
    public string | null $status;

    /**
     * Constructor de la clase.
     *
     * @param object|null $data Datos para inicializar la participación.
     */
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

    /**
     * Establece el ID del plan.
     *
     * @param int $planId El ID del plan.
     * @return void
     */
    public function setPlanId(int $planId): void {
        $this->plan_id = $planId;
    }

    /**
     * Establece el ID del usuario participante.
     *
     * @param string $userId El ID del usuario.
     * @return void
     */
    public function setUserId(string $userId): void {
        $this->user_id = $userId;
    }

    /**
     * Establece el ID del estado de la participación.
     *
     * @param int $statusId El ID del estado de la participación.
     * @return void
     */
    public function setStatusId(int $statusId): void {
        $this->status_id = $statusId;
    }

    /**
     * Establece los datos del usuario participante.
     *
     * @param array $userData Los datos del usuario.
     * @return void
     */
    public function setUserData(array $userData): void {
        $this->userData = $userData;
    }

    /**
     * Establece el estado de la participación.
     *
     * @param string $status El estado de la participación.
     * @return void
     */
    public function setStatus(string $status): void {
        $this->status = $status;
    }

    /* GETTERS */

    /**
     * Obtiene el ID del plan.
     *
     * @return int|null El ID del plan.
     */
    public function getPlanId(): int | null {
        return $this->plan_id;
    }

    /**
     * Obtiene el ID del usuario participante.
     *
     * @return string|null El ID del usuario.
     */
    public function getUserId(): string | null {
        return $this->user_id;
    }

    /**
     * Obtiene el ID del estado de la participación.
     *
     * @return int|null El ID del estado de la participación.
     */
    public function getStatusId(): int | null {
        return $this->status_id;
    }

    /**
     * Obtiene los datos del usuario participante.
     *
     * @return array|null Los datos del usuario.
     */
    public function getUserData(): array | null {
        return $this->userData;
    }

    /**
     * Obtiene el estado de la participación.
     *
     * @return string|null El estado de la participación.
     */
    public function getStatus(): string | null {
        return $this->status;
    }
}
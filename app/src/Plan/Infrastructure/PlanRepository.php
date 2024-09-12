<?php
namespace App\Plan\Infrastructure;

use App\Core\Infrastructure\Repository\CoreRepository;
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanCategory;
use App\Plan\Domain\PlanStatus;
use App\User\Domain\User;

/**
 * Repositorio para manejar las operaciones relacionadas con los planes en la base de datos.
 */
class PlanRepository extends CoreRepository {
    /**
     * Asigna una categoría a un plan.
     *
     * @param Plan $plan El plan al que se asignará la categoría.
     * @param PlanCategory $category La categoría a asociar.
     * @return bool Retorna true si la operación fue exitosa, false en caso contrario.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function assignCategoryToPlan(Plan $plan, PlanCategory $category): bool {
        $data = [
            'plan_id' => $plan->id,
            'category_id' => $category->id
        ];

        $sql = "
        INSERT INTO plan_has_category 
        (plan_id, category_id)
        VALUES
        (:plan_id, :category_id);";

        try {
            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $this->db->beginTransaction();
            $this->db->execute($stmt, $data);
            $this->db->commit();
            $this->db->disconnect();
            return true;
        } 
        catch (\Exception $e) {
            $this->db->rollBack();
            $this->db->disconnect();
            throw $e;
        }
    }

    /**
     * Obtiene todas las categorías desde la base de datos.
     *
     * @return array Un array de objetos PlanCategory que representan las categorías.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function fetchAllCategories(): array {
        try {
            $res = $this->findAll('category');

            $categories = array_map(function($category) {
                unset($category->created_at);
                unset($category->updated_at);

                return new PlanCategory($category);
            }, $res);

            return $categories;
        } 
        catch (\Exception $e) {
            throw $e;
        }

        return $res;
    }

    /**
     * Obtiene todos los planes según el ID del usuario, paginados.
     *
     * @param string $userId El ID del usuario.
     * @param int $page El número de página para la paginación.
     * @param int $itemsPerPage La cantidad de elementos por página.
     * @return array Un array de objetos Plan que representan los planes disponibles.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function fetchAllPlans(string $userId, int $page, int $itemsPerPage): array {
        $offset = ($page - 1) * $itemsPerPage;
        try {
            $data = ['user_id' => $userId];

            // [ ] Modificar la query para que solo acepte planes en los que queden
            // plazas de participación.
            $sql = "
                SELECT * 
                FROM plan 
                WHERE created_by_id != :user_id 
                ORDER BY datetime ASC
                LIMIT $itemsPerPage 
                OFFSET $offset";

            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $res = $this->db->execute($stmt, $data);

            $plans = array_map(function($planData) {
                return new Plan($planData);
            }, $res);

            return $plans;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene todos los planes creados por un usuario, paginados.
     *
     * @param string $userId El ID del usuario.
     * @param int $page El número de página para la paginación.
     * @param int $itemsPerPage La cantidad de elementos por página.
     * @return array Un array de objetos Plan que representan los planes creados.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function fetchAllCreatedPlans(string $userId, int $page, int $itemsPerPage): array {
        $offset = ($page - 1) * $itemsPerPage;
        try {
            $data = ['user_id' => $userId];

            $sql = "
                SELECT * 
                FROM plan 
                WHERE created_by_id = :user_id 
                ORDER BY datetime ASC
                LIMIT $itemsPerPage 
                OFFSET $offset";

            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $res = $this->db->execute($stmt, $data);

            $plans = array_map(function($planData) {
                return new Plan($planData);
            }, $res);

            return $plans;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene todos los planes aceptados por un usuario, paginados.
     *
     * @param string $userId El ID del usuario.
     * @param int $page El número de página para la paginación.
     * @param int $itemsPerPage La cantidad de elementos por página.
     * @return array Un array de objetos Plan que representan los planes aceptados.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function fetchAllAcceptedPlans(string $userId, int $page, int $itemsPerPage): array {
        $offset = ($page - 1) * $itemsPerPage;
        try {
            $data = ['user_id' => $userId];

            // status_id = 2 corresponde a participation_status.status = 'accepted'
            $sql = "
                SELECT * 
                FROM plan 
                WHERE id IN 
                    (SELECT DISTINCT plan_id 
                    FROM participation
                    WHERE user_id = :user_id
                    AND status_id = 2)
                ORDER BY datetime ASC
                LIMIT $itemsPerPage
                OFFSET $offset";

            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $res = $this->db->execute($stmt, $data);

            $plans = array_map(function($planData) {
                return new Plan($planData);
            }, $res);

            return $plans;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene todos los planes rechazados por un usuario, paginados.
     *
     * @param string $userId El ID del usuario.
     * @param int $page El número de página para la paginación.
     * @param int $itemsPerPage La cantidad de elementos por página.
     * @return array Un array de objetos Plan que representan los planes rechazados.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function fetchAllRejectedPlans(string $userId, int $page, int $itemsPerPage): array {
        $offset = ($page - 1) * $itemsPerPage;
        try {
            $data = ['user_id' => $userId];

            // status_id = 3 corresponde a participation_status.status = 'rejected'
            $sql = "
                SELECT * 
                FROM plan 
                WHERE id IN 
                    (SELECT DISTINCT plan_id 
                    FROM participation
                    WHERE user_id = :user_id
                    AND status_id = 3)
                ORDER BY datetime ASC
                LIMIT $itemsPerPage
                OFFSET $offset";

            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $res = $this->db->execute($stmt, $data);

            $plans = array_map(function($planData) {
                return new Plan($planData);
            }, $res);

            return $plans;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene todos los planes pendientes para un usuario, paginados.
     *
     * @param string $userId El ID del usuario.
     * @param int $page El número de página para la paginación.
     * @param int $itemsPerPage La cantidad de elementos por página.
     * @return array Un array de objetos Plan que representan los planes pendientes.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function fetchAllPendingPlans(string $userId, int $page, int $itemsPerPage): array {
        $offset = ($page - 1) * $itemsPerPage;
        try {
            $data = ['user_id' => $userId];

            // status_id = 4 corresponde a participation_status.status = 'pending'
            $sql = "
                SELECT * 
                FROM plan 
                WHERE id IN 
                    (SELECT DISTINCT plan_id 
                    FROM participation
                    WHERE user_id = :user_id
                    AND status_id = 1)
                ORDER BY datetime ASC
                LIMIT $itemsPerPage
                OFFSET $offset";

            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $res = $this->db->execute($stmt, $data);

            $plans = array_map(function($planData) {
                return new Plan($planData);
            }, $res);

            return $plans;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Cuenta todos los planes creados por un usuario.
     *
     * @param string $userId El ID del usuario.
     * @return int La cantidad de planes creados por el usuario.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function countAllCreatedPlans(string $userId): int {
        try {
            $data = ['user_id' => $userId];

            $sql = "
                SELECT COUNT(*) AS count
                FROM plan 
                WHERE created_by_id = :user_id
            ";

            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $result = $this->db->execute($stmt, $data)[0];
            $this->db->disconnect();
            return $result->count;
        }
        catch (\Exception $e) {
            $this->db->disconnect();
            throw $e;
        }
    }

    /**
     * Cuenta todos los planes que no fueron creados por un usuario.
     *
     * @param string $userId El ID del usuario.
     * @return int La cantidad de planes que no fueron creados por el usuario.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function countAllNotCreatedPlans(string $userId): int {
        try {
            $data = ['user_id' => $userId];

            $sql = "
                SELECT COUNT(*) AS count
                FROM plan 
                WHERE created_by_id != :user_id";

            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $result = $this->db->execute($stmt, $data)[0];
            $this->db->disconnect();
            return $result->count;
        } 
        catch (\Exception $e) {
            $this->db->disconnect();
            throw $e;
        }
    }

    /**
     * Cuenta todos los planes aceptados por un usuario.
     *
     * @param string $userId El ID del usuario.
     * @return int La cantidad de planes aceptados.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function countAllAcceptedPlans(string $userId): int {
        try {
            $data = ['user_id' => $userId];

            $sql = "
                SELECT COUNT(*) AS count
                FROM plan 
                WHERE id IN 
                    (SELECT DISTINCT plan_id 
                    FROM participation
                    WHERE user_id = :user_id
                    AND status_id = 2)
            ";

            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $result = $this->db->execute($stmt, $data)[0];
            $this->db->disconnect();
            return $result->count;
        }
        catch (\Exception $e) {
            $this->db->disconnect();
            throw $e;
        }
    }

    /**
     * Cuenta todos los planes rechazados por un usuario.
     *
     * @param string $userId El ID del usuario.
     * @return int La cantidad de planes rechazados.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function countAllRejectedPlans(string $userId): int {
        try {
            $data = ['user_id' => $userId];

            $sql = "
                SELECT COUNT(*) AS count
                FROM plan 
                WHERE id IN 
                    (SELECT DISTINCT plan_id 
                    FROM participation
                    WHERE user_id = :user_id
                    AND status_id = 3)
            ";

            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $result = $this->db->execute($stmt, $data)[0];
            $this->db->disconnect();
            return $result->count;
        }
        catch (\Exception $e) {
            $this->db->disconnect();
            throw $e;
        }
    }

    /**
     * Cuenta todos los planes pendientes para un usuario.
     *
     * @param string $userId El ID del usuario.
     * @return int La cantidad de planes pendientes.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function countAllPendingPlans(string $userId): int {
        try {
            $data = ['user_id' => $userId];

            $sql = "
                SELECT COUNT(*) AS count
                FROM plan 
                WHERE id IN 
                    (SELECT DISTINCT plan_id 
                    FROM participation
                    WHERE user_id = :user_id
                    AND status_id = 1)
            ";

            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $result = $this->db->execute($stmt, $data)[0];
            $this->db->disconnect();
            return $result->count;
        }
        catch (\Exception $e) {
            $this->db->disconnect();
            throw $e;
        }
    }

    /**
     * Obtiene un estado de plan por su nombre.
     *
     * @param string $status El nombre del estado del plan.
     * @return PlanStatus El objeto PlanStatus correspondiente al nombre proporcionado.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function getPlanStatusByName(string $status): PlanStatus {
        try {
            $res = $this->findBy('plan_status', 'status', $status);
            return new PlanStatus($res[0]);
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene los datos del creador de un plan por su ID.
     *
     * @param string $id El ID del creador.
     * @return User El objeto User correspondiente al ID proporcionado.
     * @throws \Exception Si ocurre un error durante la operación.
     */
    public function getPlanCreatorById(string $id): User {
        try {
            $res = $this->findBy('user', 'id', $id);
            return new User($res[0]);
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}
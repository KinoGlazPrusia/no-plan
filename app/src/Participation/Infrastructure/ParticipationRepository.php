<?php
namespace App\Participation\Infrastructure;

use App\Core\Infrastructure\Repository\CoreRepository;

/**
 * Repositorio para manejar las operaciones relacionadas con las participaciones en la base de datos.
 */
class ParticipationRepository extends CoreRepository {
    /**
     * Actualiza el estado de una participación.
     *
     * @param string $userId El ID del usuario participante.
     * @param int $planId El ID del plan.
     * @param int $statusId El ID del nuevo estado de la participación.
     * @return bool Retorna true si la operación fue exitosa, false en caso contrario.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public function updateParticipationStatus(string $userId, int $planId, int $statusId): bool {
        $data = [
            'user_id' => $userId,
            'plan_id' => $planId,
            'status_id' => $statusId
        ];

        $sql = "
        UPDATE participation 
        SET status_id = :status_id 
        WHERE user_id = :user_id AND plan_id = :plan_id;";

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
     * Obtiene las participaciones de un plan con un estado específico.
     *
     * @param int $planId El ID del plan.
     * @param string $status El estado de las participaciones a buscar.
     * @return array Un array de participaciones que cumplen con los criterios dados.
     * @throws \Exception Si ocurre algún error durante la operación.
     */
    public function fetchParticipationsByPlan(int $planId, string $status): array {
        $data = [
            'plan_id' => $planId,
            'status' => $status
        ];

        $sql = "
        SELECT * FROM participation 
        WHERE plan_id = :plan_id
        AND status_id = (
            SELECT id FROM participation_status WHERE status = :status
        )";

        try {
            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $result = $this->db->execute($stmt, $data);
            $this->db->disconnect();
            return $result;
        } 
        catch (\Exception $e) {
            $this->db->disconnect();
            throw $e;
        }
    }
}
<?php
namespace App\Plan\Infrastructure;

use App\Core\Infrastructure\Repository\CoreRepository;
use App\Plan\Domain\Plan;
use App\Plan\Domain\PlanCategory;
use App\Plan\Domain\PlanStatus;
use App\User\Domain\User;

class PlanRepository extends CoreRepository {
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

    public function countAllNotCreatedPlans(string $userId): int {
        try {
            $data = ['user_id' => $userId];

            $sql = "
                SELECT COUNT(*) AS count
                FROM plan 
                WHERE created_by_id != :user_id";

            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $result =$this->db->execute($stmt, $data)[0];
            $this->db->disconnect();
            return $result->count;
        } 
        catch (\Exception $e) {
            $this->db->disconnect();
            throw $e;
        }
    }

    public function getPlanStatusByName(string $status): PlanStatus {
        try {
            $res = $this->findBy('plan_status', 'status', $status);
            return new PlanStatus($res[0]);
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }

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
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
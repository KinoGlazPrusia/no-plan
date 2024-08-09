<?php
namespace App\Plan\Infrastructure;

use App\Core\Infrastructure\Repository\CoreRepository;
use App\Plan\Domain\PlanCategory;

class PlanRepository extends CoreRepository {
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
}
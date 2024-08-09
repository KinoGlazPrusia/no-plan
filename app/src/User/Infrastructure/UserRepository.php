<?php
namespace App\User\Infrastructure;

use App\User\Domain\User;
use App\User\Domain\UserRole;
use App\Core\Infrastructure\Repository\CoreRepository;

class UserRepository extends CoreRepository  {
    public function assignRoleToUser(User $user, UserRole $role): bool {
        $data = [
            'user_id' => $user->id,
            'role' => $role->role
        ];

        $sql = "
        INSERT INTO user_has_role 
        (user_id, role_id)
        VALUES
        (
            :user_id,
            (
                SELECT id FROM role
                WHERE role = :role
            )
        )";

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
}
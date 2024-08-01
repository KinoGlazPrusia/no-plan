<?php
namespace App\Auth\Infrastructure;

use App\User\Domain\User;
use App\User\Domain\UserRole;
use App\Core\Infrastructure\Repository\CoreRepository;

class AuthRepository extends CoreRepository {
    public function getUserByEmail(string $email): User | null {
        $res = $this->findBy('user', 'email', $email);

        if (count($res) === 0) return null;

        return new User($res[0]);
    }

    public function getUserRoles(User $user): array | null {
        $res = [];

        $sql = "
            SELECT r.role FROM
            user_has_role ur, role r
            WHERE ur.user_id = :user_id
            AND ur.role_id = r.id
        ";
        
        try {
            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $res = $this->db->execute($stmt, ['user_id' => $user->id]);
            $this->db->disconnect();
        } 
        catch (Exception $e) {
            $this->db->disconnect();
            throw $e;
        }

        if (count($res) === 0) return null;

        $roles = array_map(function($role) {
            return new UserRole($role->role);
        }, $res);

        return $roles;
    }
}
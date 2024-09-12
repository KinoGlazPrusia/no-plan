<?php
namespace App\Auth\Infrastructure;

use App\User\Domain\User;
use App\User\Domain\UserRole;
use App\Core\Infrastructure\Repository\CoreRepository;

/**
 * Repositorio para manejar operaciones relacionadas con la autenticación y usuarios.
 */
class AuthRepository extends CoreRepository {
    
    /**
     * Obtiene un usuario por su correo electrónico.
     *
     * @param string $email El correo electrónico del usuario a buscar.
     * @return User|null El objeto del usuario si se encuentra, o null si no se encuentra.
     */
    public function getUserByEmail(string $email): User | null {
        $res = $this->findBy('user', 'email', $email);

        if (count($res) === 0) return null;

        return new User($res[0]);
    }

    /**
     * Obtiene los roles de un usuario.
     *
     * @param User $user El objeto del usuario del cual se desean obtener los roles.
     * @return UserRole[]|null Un array de objetos UserRole si se encuentran roles, o null si no se encuentran roles.
     * @throws \Exception Si ocurre un error durante la consulta a la base de datos.
     */
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
        catch (\Exception $e) {
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

<?php
namespace App\User\Application;

use Exception;
use App\User\Domain\User;
use App\User\Domain\UserRole;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IRepository;

class AssignRolesToNewUserUseCase implements IUseCase {
    public static function assign(
        IRepository $repository, 
        User $user,
        array $roles
    ): void {
        // Esta función devolvera un array de value objects UserRole
        foreach($roles as $role) {
            try {
                $repository->assignRoleToUser($user, $role);
            } 
            catch (Exception $e) {
                throw $e;
            }
        }
    }
}
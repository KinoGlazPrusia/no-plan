<?php
namespace App\User\Application;

use Exception;
use App\User\Domain\User;
use App\User\Domain\UserRole;
use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IRepository;

/**
 * Caso de uso para asignar roles a un nuevo usuario.
 */
class AssignRolesToNewUserUseCase implements IUseCase {
    
    /**
     * Asigna una lista de roles a un usuario.
     *
     * @param IRepository $repository Repositorio para realizar la asignación de roles.
     * @param User $user El objeto del usuario al que se le asignarán los roles.
     * @param UserRole[] $roles Un array de objetos UserRole que representan los roles a asignar.
     * @return void
     * @throws Exception Si ocurre un error durante la asignación de roles.
     */
    public static function assign(
        IRepository $repository, 
        User $user,
        array $roles
    ): void {
        // Esta función devolverá un array de value objects UserRole
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

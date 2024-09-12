<?php
namespace App\User\Domain;

/**
 * Value Object que representa un rol de usuario.
 * 
 * Esta clase se inicializa con uno de los valores constantes definidos en la clase `UserRole`.
 * Por ejemplo, se puede crear una instancia con `new UserRole(UserRole::ADMIN)`.
 */
class UserRole {
    public const ADMIN = 'admin';
    public const USER = 'user';

    /**
     * Rol del usuario.
     * 
     * @var string
     */
    readonly public string $role;

    /**
     * Constructor de la clase UserRole.
     * 
     * @param string $role Valor del rol del usuario. Debe ser uno de los valores constantes definidos en la clase `UserRole`.
     */
    public function __construct(string $role) {
        $this->role = $role;
    }
}

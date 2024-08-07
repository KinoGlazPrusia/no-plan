<?php
namespace App\User\Domain;

/* Value Object */
/* Este value object se inicializa con el valor de una de las constantes de la clase UserRole
Con lo que la propia clase ya contiene todos los valores posibles
Por ejemplo: new UserRole(UserRole::ADMIN)  */
class UserRole {
    const ADMIN = 'admin';
    const USER = 'user';

    readonly public string  $role;

    public function __construct($role) {
        $this->role = $role;
    }
}
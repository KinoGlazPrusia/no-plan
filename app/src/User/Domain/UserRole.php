<?php
namespace App\User\Domain;

class UserRole {
    const ADMIN = 'admin';
    const USER = 'user';

    readonly public string  $role;

    public function __construct($role) {
        $this->role = $role;
    }
}
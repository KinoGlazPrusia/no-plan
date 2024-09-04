<?php
namespace App\Auth\Application\Exceptions;

class InvalidCredentialsException extends \Exception {
    public function __construct() {
        parent::__construct("Email or password are not valid");
    }
}
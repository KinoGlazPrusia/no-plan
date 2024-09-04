<?php
namespace App\Auth\Application\Exceptions;

class EmailDontExistsException extends \Exception {
    public function __construct() {
        parent::__construct("This email doesn't exists");
    }
}
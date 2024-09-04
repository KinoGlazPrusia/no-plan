<?php
namespace App\Auth\Application\Exception;

class UnauthorizedAccessException extends \Exception {
    public function __construct() {
        parent::__construct("Unauthorized access");
    }
}
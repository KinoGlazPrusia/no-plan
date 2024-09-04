<?php
namespace App\Core\Application\Exception;

class ValidationException extends \Exception {
    public function __construct() {
        parent::__construct("Validation error");
    }
}
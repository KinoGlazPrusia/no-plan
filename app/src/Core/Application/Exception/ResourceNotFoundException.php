<?php
namespace App\Core\Application\Exception;

class ResourceNotFoundException extends \Exception {
    public function __construct() {
        parent::__construct("Resource not found");
    }
}
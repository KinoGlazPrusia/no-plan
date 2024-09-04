<?php
namespace App\Auth\Application\Exception;

class InvalidAccessTokenException extends \Exception {
    public function __construct() {
        parent::__construct("Invalid access token");
    }
}
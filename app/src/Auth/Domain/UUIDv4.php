<?php
namespace App\Auth\Domain;

use Ramsey\Uuid\Uuid;

/* Value object */
class UUIDv4 {
    public static function get(): string {
        return Uuid::uuid4()->toString();
    }
}
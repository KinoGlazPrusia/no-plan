<?php
namespace App\Core\Infrastructure\Service;

class Sanitizer
{
    public static function sanitizeEmail(string $email): string {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
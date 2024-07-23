<?php
namespace App\Core\Infrastructure\Service;

class Sanitizer
{
    public static function sanitizeEmail(string $email): string {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function sanitizeString(string $string): string {
        $sanitized = trim($string);
        $sanitized = stripslashes($sanitized);
        $sanitized = strip_tags($sanitized);
        $sanitized = htmlspecialchars($sanitized);
        return $sanitized;
    }

    public static function sanitizeName(string $name): string {
        $sanitized = self::sanitizeString($name);
        $sanitized = strtolower($sanitized);
        $sanitized = strtoupper($sanitized[0]) . substr($sanitized, 1);
        return $sanitized;
    }
}
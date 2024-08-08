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

    public static function sanitizeInt(int $int): int {
        $sanitized = self::sanitizeString($int);
        return $sanitized;
    }

    public static function sanitizeName(string $name): string {
        $sanitized = self::sanitizeString($name);
        $sanitized = strtolower($sanitized);
        $sanitized = strtoupper($sanitized[0]) . substr($sanitized, 1);
        return $sanitized;
    }

    public static function sanitizeDate(string $birth_date): string {
        $sanitized = self::sanitizeString($birth_date);
        return $sanitized;
    }
}
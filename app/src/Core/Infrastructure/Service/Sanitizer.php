<?php
namespace App\Core\Infrastructure\Service;

class Sanitizer
{
    /* const EMAIL = 'email';
    const STRING = 'string';
    const INT = 'int';
    const NAME = 'name';
    const DATE = 'date';
    const DATA_TYPES = 'data_types';

    const SANITIZE_FUNC = [
        self::EMAIL => [self::class, 'sanitizeEmail'],
        self::STRING => [self::class, 'sanitizeString'],
        self::INT => [self::class, 'sanitizeInt'],
        self::NAME => [self::class, 'sanitizeName'],
        self::DATE => [self::class, 'sanitizeDate'],
    ]; */

    public static function sanitizeEmail(string $email): string {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
    }

    public static function sanitizeString(string $string): string {
        $sanitized = trim($string);
        $sanitized = stripslashes($sanitized);
        $sanitized = strip_tags($sanitized);
        $sanitized = htmlspecialchars($sanitized);
        return $sanitized;
    }

    public static function sanitizeInt(int | string $int): int {
        return (int)filter_var($int, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function sanitizeName(string $name): string {
        $sanitized = self::sanitizeString($name);
        $sanitized = strtolower($sanitized);
        strlen($sanitized) > 0 ? $sanitized = strtoupper($sanitized[0]) . substr($sanitized, 1) : $sanitized;
        return $sanitized;
    }

    public static function sanitizeDate(string $birth_date): string {
        $sanitized = preg_replace('/[^0-9\-]/', '', $birth_date);
        return $sanitized;
    }

    /* public static function sanitizeData(array $data): array { */
        /* 
        Los datos de entrada se reciben como un array asociativo del tipo de dato y el valor:
            $data = [
                'email' => 'email@email.com',
                'name' => 'John Doe',
                'date' => '2022-01-01',
                'int' => 1,
                'string' => 'string'
            ];
        */
        /* $res = [];
        foreach ($data as $type => $value) {
            array_push($res, call_user_func(self::SANITIZE_FUNC[$type], $value));
        }
        return $res;
    } */
}
<?php
namespace App\Core\Infrastructure\Service;

/**
 * Clase Sanitizer que proporciona métodos para sanitizar diferentes tipos de datos.
 */
class Sanitizer
{
    /**
     * Sanitiza una dirección de correo electrónico.
     *
     * @param string $email La dirección de correo electrónico a sanitizar.
     * @return string La dirección de correo electrónico sanitizada o una cadena vacía si no es válida.
     */
    public static function sanitizeEmail(string $email): string {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
    }

    /**
     * Sanitiza una cadena de texto.
     *
     * @param string $string La cadena de texto a sanitizar.
     * @return string La cadena de texto sanitizada.
     */
    public static function sanitizeString(string $string): string {
        $sanitized = trim($string);
        $sanitized = stripslashes($sanitized);
        $sanitized = strip_tags($sanitized);
        $sanitized = htmlspecialchars($sanitized);
        return $sanitized;
    }

    /**
     * Sanitiza un entero.
     *
     * @param int|string $int El entero a sanitizar.
     * @return int El entero sanitizado.
     */
    public static function sanitizeInt(int | string $int): int {
        return (int)filter_var($int, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Sanitiza un nombre.
     *
     * @param string $name El nombre a sanitizar.
     * @return string El nombre sanitizado.
     */
    public static function sanitizeName(string $name): string {
        $sanitized = self::sanitizeString($name);
        $sanitized = strtolower($sanitized);
        strlen($sanitized) > 0 ? $sanitized = strtoupper($sanitized[0]) . substr($sanitized, 1) : $sanitized;
        return $sanitized;
    }

    /**
     * Sanitiza una fecha.
     *
     * @param string $birth_date La fecha a sanitizar.
     * @return string La fecha sanitizada.
     */
    public static function sanitizeDate(string $birth_date): string {
        $sanitized = preg_replace('/[^0-9\-]/', '', $birth_date);
        return $sanitized;
    }
}
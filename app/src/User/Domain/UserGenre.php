<?php
namespace App\User\Domain;

/**
 * Value Object que representa los géneros disponibles para los usuarios.
 */
class UserGenre {
    public const MALE = 'M';
    public const FEMALE = 'F';
    public const NON_BINARY = 'NB';
    public const OTHER = 'O';
    public const NOT_SET = 'NS';

    /**
     * Obtiene la representación textual del código de género.
     *
     * @param string $code Código del género.
     * @return string Representación textual del género.
     */
    public static function getVerbose(string $code): string {
        switch ($code) {
            case 'M':
                return 'male';
            case 'F':
                return 'female';
            case 'NB':
                return 'non binary';
            case 'O':
                return 'other';
            default:
                return 'not set';
        }
    }

    /**
     * Obtiene todos los códigos de género disponibles.
     *
     * @return string[] Array de códigos de género.
     */
    public static function getAll(): array {
        return [
            self::MALE,
            self::FEMALE,
            self::NON_BINARY,
            self::OTHER,
            self::NOT_SET
        ];
    }
}

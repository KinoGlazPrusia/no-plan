<?php
namespace App\User\Domain;

/* Value Object */
class UserGenre {
    const MALE = 'M';
    const FEMALE = 'F';
    const NON_BINARY = 'NB';
    const OTHER = 'O';
    const NOT_SET = 'NS';

    public static function getVerbose(string $code) {
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

    public static function getAll() {
        return [
            self::MALE,
            self::FEMALE,
            self::NON_BINARY,
            self::OTHER,
            self::NOT_SET
        ];
    }
}
<?php
namespace App\Core\Infrastructure\Service;

class Helper {
    public static function filterSensitiveData(array $keysToUnset, array $data): array {
        $keysToUnset = array_flip($keysToUnset);

        return array_diff_key($data, $keysToUnset);
    }
}
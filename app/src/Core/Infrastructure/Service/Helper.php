<?php
namespace App\Core\Infrastructure\Service;

/**
 * Clase Helper que proporciona métodos utilitarios para la aplicación.
 */
class Helper {
    /**
     * Filtra datos sensibles eliminando ciertas claves de un arreglo.
     *
     * @param array $keysToUnset Las claves que se deben eliminar.
     * @param array $data El arreglo de datos de donde se eliminarán las claves.
     * @return array El arreglo de datos sin las claves sensibles.
     */
    public static function filterSensitiveData(array $keysToUnset, array $data): array {
        $keysToUnset = array_flip($keysToUnset);

        return array_diff_key($data, $keysToUnset);
    }
}
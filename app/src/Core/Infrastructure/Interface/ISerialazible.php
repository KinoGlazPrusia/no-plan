<?php

interface ISerialazible {
    /**
     * Puede retornar los atributos del modelo en un array asociativo.
     * @return array asociativo con los campos de la tabla del modelo exclusivamente.
     */
    public static function serialize(bool $includeNulls = true): array;
}
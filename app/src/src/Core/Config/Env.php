<?php
namespace App\Core\Config;

class Env
{
    /* HOST */
    const APP_HOST = 'http://localhost/';

    /* DATABASE */
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_NAME = 'no_plan';

    /* PATHS */
    const ROOT = 'no-plan/app/';
    const PUBLIC = self::ROOT . 'public/';
    const SRC = self::ROOT . 'src/';

    public static function test($param) {
        echo "Hola mundo!<br>";
        echo json_encode($param);
    }
}


<?php
namespace App;

/**
 * Clase de configuración de entorno que define constantes para la aplicación.
 */
class Env
{
    /* STATUS */
    const STATUS = 'prod'; // Puede ser 'dev' o 'prod'

    /* HOST */
    const APP_HOST = 'http://147.83.7.155/'; //http://localhost/

    /* DATABASE */
    const DB_TYPE = 'mysql';
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_NAME = 'no_plan_db';

    /* PATHS */
    const BASE_DIR = 'no-plan/app/';
    const PUBLIC_DIR = self::BASE_DIR . 'public/';
    const AVATAR_IMAGES_DIR = self::BASE_DIR . 'public/assets/images/avatar/';
    const PLAN_IMAGES_DIR = self::BASE_DIR . 'public/assets/images/plan/';
    const SRC_DIR = self::BASE_DIR . 'src/';

    /* SESSION */
    const SESSION_TOKEN_EXPIRATION_TIME = 60 * 60 * 24; // 24 Horas
}


<?php
namespace App;

/**
 * Clase de configuración de entorno que define constantes para la aplicación.
 */
class Env
{
    /* HOST */

    /**
     * Dirección base de la aplicación.
     * 
     * @var string
     */
    const APP_HOST = 'http://localhost/';

    /* DATABASE */

    /**
     * Tipo de base de datos.
     * 
     * @var string
     */
    const DB_TYPE = 'mysql';

    /**
     * Host de la base de datos.
     * 
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Usuario de la base de datos.
     * 
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Contraseña de la base de datos.
     * 
     * @var string
     */
    const DB_PASS = '';

    /**
     * Nombre de la base de datos.
     * 
     * @var string
     */
    const DB_NAME = 'no_plan_db';

    /* PATHS */

    /**
     * Directorio base de la aplicación.
     * 
     * @var string
     */
    const BASE_DIR = 'no-plan/app/';

    /**
     * Directorio público de la aplicación.
     * 
     * @var string
     */
    const PUBLIC_DIR = self::BASE_DIR . 'public/';

    /**
     * Directorio público donde se almacenan las imágenes de los avatares de usuario.
     * 
     * @var string
     */
    const AVATAR_IMAGES_DIR = self::BASE_DIR . 'public/assets/images/avatar/';

    /**
     * Directorio público donde se almacenan las imágenes de los planes.
     * 
     * @var string
     */
    const PLAN_IMAGES_DIR = self::BASE_DIR . 'public/assets/images/plan/';

    /**
     * Directorio source de la aplicación.
     * 
     * @var string
     */
    const SRC_DIR = self::BASE_DIR . 'src/';
}


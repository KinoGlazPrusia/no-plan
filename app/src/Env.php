<?php
namespace App;

/**
 * Clase de configuración de entorno que define constantes para la aplicación.
 */
class Env
{
    private static $config;

    /* STATUS */
    public static $STATUS; 

    /* HOST */
    public static $APP_HOST;

    /* DATABASE */
    public static $DB_TYPE;
    public static $DB_HOST;
    public static $DB_USER;
    public static $DB_PASS;
    public static $DB_NAME;

    /* PATHS */
    public static $BASE_DIR;
    public static $PUBLIC_DIR;
    public static $AVATAR_IMAGES_DIR;
    public static $PLAN_IMAGES_DIR;
    public static $SRC_DIR;

    /* SESSION */
    public static $SESSION_TOKEN_EXPIRATION_TIME; // 24 Horas

    private static function loadConfig()
    {
        if (!self::$config) {
            $configFile = __DIR__ . '/../config.json';
            $json = file_get_contents($configFile);
            $configs = json_decode($json, true);
            $mode = $configs['mode']; // Obtén el modo del archivo de configuración
            if(isset($configs[$mode])){
                self::$config = $configs[$mode];
                self::$STATUS = $mode;
            } else {
                throw new \Exception("La configuración para el entorno '" . $mode . "' no está definida.");
            }
        }
    }

    private static function initialize()
    {
        self::$APP_HOST = self::$config['app_host'];

        self::$DB_TYPE = self::$config['db_type'];
        self::$DB_HOST = self::$config['db_host'];
        self::$DB_USER = self::$config['db_user'];
        self::$DB_PASS = self::$config['db_pass'];
        self::$DB_NAME = self::$config['db_name'];

        self::$BASE_DIR = self::$config['base_dir'];
        self::$PUBLIC_DIR = self::$config['public_dir'];
        self::$AVATAR_IMAGES_DIR = self::$config['avatar_images_dir'];
        self::$PLAN_IMAGES_DIR = self::$config['plan_images_dir'];
        self::$SRC_DIR = self::$config['src_dir'];

        self::$SESSION_TOKEN_EXPIRATION_TIME = self::$config['session_token_expiration_time'];
    }

    // Método estático para inicializar la configuración una vez cuando la clase es cargada por el autoloader al ser requerida.
    public static function init()
    {
        self::loadConfig();
        self::initialize();
    }
}

Env::init();


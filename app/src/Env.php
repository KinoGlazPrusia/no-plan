<?php
namespace App;

/**
 * Clase de configuración de entorno que define constantes para la aplicación.
 *
 * Esta clase se asegura de cargar y almacenar configuraciones específicas 
 * del entorno desde un archivo JSON de configuración.
 */
class Env
{
    /**
     * @var array Almacena la configuración cargada desde el archivo JSON.
     */
    private static $config;

    /**
     * @var string Estado de la aplicación (entorno).
     */
    public static $STATUS;

    /**
     * @var string Host de la aplicación.
     */
    public static $APP_HOST;

    /**
     * @var string Tipo de la base de datos (ej. mysql, postgres).
     */
    public static $DB_TYPE;

    /**
     * @var string Dirección del host de la base de datos.
     */
    public static $DB_HOST;

    /**
     * @var string Usuario para la conexión a la base de datos.
     */
    public static $DB_USER;

    /**
     * @var string Contraseña para la conexión a la base de datos.
     */
    public static $DB_PASS;

    /**
     * @var string Nombre de la base de datos.
     */
    public static $DB_NAME;

    /**
     * @var string Ruta base del proyecto.
     */
    public static $BASE_DIR;

    /**
     * @var string Ruta del directorio público.
     */
    public static $PUBLIC_DIR;

    /**
     * @var string Ruta del directorio de imágenes de avatares.
     */
    public static $AVATAR_IMAGES_DIR;

    /**
     * @var string Ruta del directorio de imágenes de planes.
     */
    public static $PLAN_IMAGES_DIR;

    /**
     * @var string Ruta del directorio de código fuente.
     */
    public static $SRC_DIR;

    /**
     * @var int Tiempo de expiración del token de sesión en segundos (por defecto 24 horas).
     */
    public static $SESSION_TOKEN_EXPIRATION_TIME; // 24 Horas

    /**
     * Carga la configuración desde un archivo JSON y la asigna a la variable $config.
     *
     * @throws \Exception Si el entorno especificado en el archivo de configuración no está definido.
     * @return void
     */
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

    /**
     * Inicializa todas las variables estáticas con los valores de la configuración cargada.
     *
     * @return void
     */
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

    /**
     * Método estático para inicializar la configuración una vez cuando la clase es cargada.
     *
     * @return void
     */
    public static function init()
    {
        self::loadConfig();
        self::initialize();
    }
}

Env::init();
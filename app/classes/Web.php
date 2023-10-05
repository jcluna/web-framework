<?php

/**
 * Clase principal 
 */
class Web
{
    // propiedades del framework
    private static $framework = 'Web Framework';
    private static $version = '1.0.0.0';
    private $uri = [];

    /**
     * Crear una instancia del tipo Web
     * 
     * @return void
     */
    function __construct()
    {
        $this->init();
    }

    /**
     * Recuperar el nombre del framework
     * @return string
     */
    public static function get_name()
    {
        return self::$framework;
    }

    /**
     * Recuperar la versión del framework
     * @return string
     */
    public static function get_version()
    {
        return self::$version;
    }

    /**
     * Ejecutar cada 'metodo' de forma secuencial
     * 
     * @return void
     */
    private function init()
    {
        $this->init_session();
        $this->init_load_config();
        $this->init_load_functions();
        $this->init_autoload();
        $this->init_csrf();
        $this->dispatch();
    }

    /**
     * Iniciar la sesión del sistema
     * 
     * @return void
     */
    private function init_session()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Cargar la configuración del sistema
     * 
     * @return void
     */
    private function init_load_config()
    {
        $config = 'web_config.php';
        $file = 'app/config/' . $config;

        // validar la existencia del archivo de configuración
        if (!is_file($file)) {
            die(sprintf('El archivo [%s] no existe, y es necesario para que %s funcione.', $config, self::$framework));
        }

        // cargar el archivo de configuración
        require_once $file;

        return;
    }

    /**
     * Cargar todas las funciones del sistema (core) y del usuario (custom)
     * 
     * @return void
     */
    private function init_load_functions()
    {
        $core = 'web_core.php';
        $custom = 'web_custom.php';

        // validar la existencia del archivo de funciones core
        $file = FUNCTIONS . $core;
        if (!is_file($file)) {
            die(sprintf('El archivo [%s] no existe, y es necesario para que %s funcione.', $core, self::$framework));
        }

        // cargar las funciones core
        require_once $file;

        // validar la existencia del archivo de funciones custom
        $file = FUNCTIONS . $custom;
        if (!is_file($file)) {
            die(sprintf('El archivo %s no existe, y es necesario para que %s funcione.', $core, self::$framework));
        }

        // cargar las funciones custom
        require_once $file;

        return;
    }

    /**
     * Cargar todos los archivos de forma automática
     * 
     * @return void
     */
    private function init_autoload()
    {
        // cargar e inicializar el autoloader
        require_once CLASSES . 'Autoloader.php';
        Autoloader::init();
        return;
    }

    /**
     * Crear un nuevo token para la sesión del usuario
     * @return void
     */
    private function init_csrf()
    {
        $csrf = new Csrf();
    }

    /**
     * Filtrar y descomponer elementos de la URI
     * 
     * @return void
     */
    private function filter_url()
    {
        if (isset($_GET['uri'])) {
            $uri = filter_var($_GET['uri'], FILTER_SANITIZE_URL);
            $this->uri = explode('/', strtolower(rtrim($uri, '/')));
        }

        return;
    }

    /**
     * Cargar y ejecutar el controlador solicitado
     * 
     * @return void
     */
    private function dispatch()
    {
        // filtrar y recuperar la uri solicitada
        $this->filter_url();

        // -- recuperar el nombre del controlador
        if (isset($this->uri[0])) {
            $current_controller = $this->uri[0];
            unset($this->uri[0]);
        } else {
            $current_controller = DEFAULT_H_CONTROLLER;
        }

        // validar la existencia del controlador
        $controller = $current_controller . 'Controller';
        if (!class_exists($controller)) {
            // no existe el controlador, se utiliza el controlador de error
            $controller = DEFAULT_E_CONTROLLER . 'Controller';
            $current_controller = DEFAULT_E_CONTROLLER;
        }

        // -- recuperar el nombre del metodo
        if (isset($this->uri[1])) {
            $current_method = str_replace('-', '_', $this->uri[1]);
            unset($this->uri[1]);

            // validar la existencia del metodo en el controlador
            if (!method_exists($controller, $current_method)) {
                $controller = DEFAULT_E_CONTROLLER . 'Controller';
                $current_controller = DEFAULT_E_CONTROLLER;
                $current_method = DEFAULT_METHOD;
            }
        } else {
            $current_method = DEFAULT_METHOD;
        }

        // -- crear constantes para el controlador y el metodo
        define('CONTROLLER', $current_controller);
        define('METHOD', $current_method);

        // -- recuperar los parametros despues del controlador y el metodo
        $params = array_values(empty($this->uri) ? [] : $this->uri);

        // -- ejecutar el metodo del controlador solicitado
        $instance = new $controller;
        if (empty($params)) {
            call_user_func([$instance, $current_method]);
        } else {
            call_user_func_array([$instance, $current_method], $params);
        }
    }

    /**
     * Ejecutar Web Framework
     * 
     * @return void
     */
    public static function start()
    {
        $web = new self();
        return;
    }
}

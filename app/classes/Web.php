<?php

/**
 * Clase principal 
 */
class Web
{
    // propiedades del framework
    private $framework = 'Web Framework';
    private $version = '0.1.0.0';
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
        $this->dispatch();
    }

    /**
     * Iniciar la sesión del sistema
     * 
     * @return void
     */
    private function init_session()
    {
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
            die(sprintf('El archivo %s no existe, y es necesario para que %s funcione.', $config, $this->framework));
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
            die(sprintf('El archivo %s no existe, y es necesario para que %s funcione.', $core, $this->framework));
        }

        // cargar las funciones core
        require_once $file;

        // validar la existencia del archivo de funciones custom
        $file = FUNCTIONS . $custom;
        if (!is_file($file)) {
            die(sprintf('El archivo %s no existe, y es necesario para que %s funcione.', $core, $this->framework));
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
        // cargar las clases principales
        require_once CLASSES . 'Db.php';
        require_once CLASSES . 'Model.php';
        require_once CLASSES . 'Controller.php';

        // cargar los controladores por defecto
        require_once CONTROLLERS . DEFAULT_H_CONTROLLER . 'Controller.php';
        require_once CONTROLLERS . DEFAULT_E_CONTROLLER . 'Controller.php';

        return;
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
        }

        // -- recuperar el nombre del metodo
        if (isset($this->uri[1])) {
            $current_method = str_replace('-', '_', $this->uri[1]);
            unset($this->uri[1]);

            // validar la existencia del metodo en el controlador
            if (!method_exists($controller, $current_method)) {
                $controller = DEFAULT_E_CONTROLLER . 'Controller';
                $current_method = DEFAULT_METHOD;
            }
        } else {
            $current_method = DEFAULT_METHOD;
        }

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
}

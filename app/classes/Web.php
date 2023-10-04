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
        $this->filter_url();
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
        require_once CLASSES . 'Db.php';
        require_once CLASSES . 'Model.php';
        require_once CLASSES . 'Controller.php';

        return;
    }

    /**
     * Filtrar y descomponer elementos de la URI
     * 
     * @return array
     */
    private function filter_url()
    {
        if (isset($_GET['uri'])) {
            $uri = filter_var($_GET['uri'], FILTER_SANITIZE_URL);
            $this->uri = explode('/', strtolower(rtrim($uri, '/')));
        }

        return $this->uri;
    }
}

<?php

// identificar la forma de ejecución del sistema: local o remota
define('IS_LOCAL', in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));

// definir el uso horario o timezone del sistema
date_default_timezone_set('America/Mexico_City');

// definir el idioma del sistema
define('LANGUAGE', 'es');

// definir la ruta base del sistema
define('BASE_PATH', IS_LOCAL ? '/web-framework/' : '/app/');

// definir sal (salt) del sistema para protección
define('AUTH_SALT', 'W3bFr4m3w0rk<3');

// definir el puerto y dirección web del sistema
define('PORT', '80');
define('URL', IS_LOCAL ? 'http://localhost:' . PORT . BASE_PATH : 'http://host:' . PORT . BASE_PATH);

// definir rutas de directorios y archivos
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd() . DS);
define('APP', ROOT . 'app' . DS);
define('CLASSES', APP . 'classes' . DS);
define('CONFIG', APP . 'config' . DS);
define('CONTROLLERS', APP . 'controllers' . DS);
define('FUNCTIONS', APP . 'functions' . DS);
define('MODELS', APP . 'models' . DS);

define('TEMPLATES', ROOT . 'templates' . DS);
define('INCLUDES', TEMPLATES . 'includes' . DS);
define('MODULES', TEMPLATES . 'modules' . DS);
define('VIEWS', TEMPLATES . 'views' . DS);

// definir rutas de recursos
define('ASSETS', URL . 'assets/');
define('CSS', ASSETS . 'css/');
define('FAVICON', ASSETS . 'favicon/');
define('FONTS', ASSETS . 'fonts/');
define('IMAGES', ASSETS . 'images/');
define('JS', ASSETS . 'js/');
define('PLUGINS', ASSETS . 'plugins/');
define('UPLOADS', ASSETS . 'uploads/');

// definir controladores y método por defecto
define('DEFAULT_H_CONTROLLER', 'home');
define('DEFAULT_E_CONTROLLER', 'error');
define('DEFAULT_METHOD', 'index');

// definir credenciales de la base de datos

// -- BASE DE DATOS LOCAL - DESARROLLO
define('LDB_ENGINE', 'mysql');
define('LDB_HOST', 'localhost');
define('LDB_NAME', 'web');
define('LDB_USR', 'root');
define('LDB_PWD', '');
define('LDB_CHARSET', 'latin1');

// -- BASE DE DATOS REMOTA - PRODUCCIÓN
define('DB_ENGINE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', '__remote_db__');
define('DB_USR', '__remote_db__');
define('DB_PWD', '__remote_db__');
define('DB_CHARSET', '__remote_db__');

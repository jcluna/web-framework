<?php

class View
{
    /**
     * 
     */
    public static function render($view, $data = [])
    {
        // convertir el array en objeto
        $d = to_object($data);

        // validar la existencia de la vista
        if (!is_file(VIEWS . CONTROLLER . DS . $view . 'View.php')) {
            die(sprintf('No existe la vista %sView en la carpeta %s', $view, CONTROLLER));
        }

        // cargar la vista
        require_once VIEWS . CONTROLLER . DS . $view . 'View.php';
        exit(); // evitar cualquier ejecución
    }
}

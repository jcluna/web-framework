<?php

class Redirect
{
    private $location;

    /**
     * Redirigir la solicitud a una sección del sistema
     * 
     * @return void
     */
    public static function to($location)
    {
        $self = new self();
        $self->location = $location;

        $navigate = URL . $self->location;

        if (headers_sent()) {
            // ya hay cabeceras, usar redirección con js
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $navigate . '";';
            echo '</script>' . "\r\n";

            echo '<nonscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $navigate . '" />';
            echo '</nonscript>' . "\r\n";

            die(); // terminar procesamiento
        }

        if (strpos($self->location, 'http') !== false) {
            // realizar una redicción externa
            header('Location: ' . $self->location);
            die(); // terminar procesamiento
        }

        // redirección a una sección del sistema
        header('Location: ' . URL . $self->location);
        die(); // terminar procesamiento
    }
}

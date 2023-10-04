<?php

class Flasher
{
    private $valid_types = [
        'primary', 'secondary', 'success', 'danger',
        'warning', 'info', 'light', 'dark',
    ];
    private $default = 'primary';
    private $type;
    private $msg;

    /**
     * Guardar una notificación flash
     * @param string|array $msg
     * @param string $type
     * @return void
     */
    private static function new($msg, $type = null)
    {
        $self = new self();

        // evaluar la existencia del tipo especificado
        // de lo contrario, utilizar el tipo por defecto
        $self->type = ($type == null ? $self->default : $type);
        $self->type = in_array($type, $self->valid_types) ? $type : $self->default;

        // guardar la notificación o notificaciones en sesión
        if (is_array($msg)) {
            foreach ($msg as $m) {
                $_SESSION[$self->type][] = $m;
            }
        } else {
            $_SESSION[$self->type][] = $msg;
        }
        return;
    }

    /**
     * Registrar notificación tipo PRIMARY
     * @return void;
     */
    public static function primary($msg)
    {
        return self::new($msg, 'primary');
    }

    /**
     * Registrar notificación tipo SECONDARY
     * @return void;
     */
    public static function secondary($msg)
    {
        return self::new($msg, 'secondary');
    }

    /**
     * Registrar notificación tipo SUCCESS
     * @return void;
     */
    public static function success($msg)
    {
        return self::new($msg, 'success');
    }

    /**
     * Registrar notificación tipo DANGER
     * @return void;
     */
    public static function danger($msg)
    {
        return self::new($msg, 'danger');
    }

    /**
     * Registrar notificación tipo WARNING
     * @return void;
     */
    public static function warning($msg)
    {
        return self::new($msg, 'warning');
    }

    /**
     * Registrar notificación tipo INFO
     * @return void;
     */
    public static function info($msg)
    {
        return self::new($msg, 'info');
    }

    /**
     * Registrar notificación tipo LIGHT
     * @return void;
     */
    public static function light($msg)
    {
        return self::new($msg, 'light');
    }

    /**
     * Registrar notificación tipo DARK
     * @return void;
     */
    public static function dark($msg)
    {
        return self::new($msg, 'dark');
    }

    /**
     * Renderizar las notificaciones
     * @return string
     */
    public static function flash()
    {
        $self = new self();
        $output = '';

        foreach ($self->valid_types as $type) {
            if (isset($_SESSION[$type]) && !empty($_SESSION[$type])) {
                foreach ($_SESSION[$type] as $msg) {
                    if (isset($msg) && !empty($msg)) {
                        $output .= '<div class="alert alert-' . $type . ' alert-dismissible show fade" role="alert">';
                        $output .= $msg;
                        $output .= ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        $output .= "</div>\r\n";
                    }
                }

                unset($_SESSION[$type]);
            }
        }

        return $output;
    }
}

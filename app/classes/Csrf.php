<?php

class Csrf
{
    private $token, $token_expiration;
    private $length = 32;
    private $expiration_time = 60 * 5;

    public function __construct()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $this->generate();
            $_SESSION['csrf_token'] = [
                'token' => $this->token,
                'expiration' => $this->token_expiration
            ];
            return $this;
        }

        $this->token = $_SESSION['csrf_token']['token'];
        $this->token_expiration = $_SESSION['csrf_token']['expiration'];
        return $this;
    }

    /**
     * Recuperar el token generado
     * @return string
     */
    public function get_token()
    {
        return $this->token;
    }

    /**
     * Recuperar el tiempo de expiración
     * @return int
     */
    public function get_expiration()
    {
        return $this->token_expiration;
    }

    /**
     * Validar el token CSRF y su expiración
     * @return bool
     */
    public static function validate($token, $expiration = false)
    {
        $self = new self();
        if ($expiration && $self->get_expiration() < time()) {
            // el token ha expirado
            return false;
        }

        if ($token !== $self->get_token()) {
            // el token no es valido
            return false;
        }

        return true;
    }

    /**
     * Generar un nuevo token
     * @return $this
     */
    private function generate()
    {
        if (function_exists('bin2hex')) {
            $this->token = bin2hex(random_bytes($this->length));
        } elseif (function_exists('mcrypt_create_iv')) {
            $this->token = bin2hex(mcrypt_create_iv($this->length, MCRYPT_DEV_URANDOM));
        } else {
            $this->token = bin2hex(openssl_random_pseudo_bytes($this->length));
        }

        $this->token_expiration = time() + $this->expiration_time;
        return $this;
    }
}

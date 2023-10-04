<?php

class homeController extends Controller
{
    function __construct()
    {
    }

    function index()
    {
        $data = ['title' => 'Home'];
        View::render('web', $data);
    }

    function test()
    {
        View::render('test');
    }

    function flash()
    {
        Flasher::success('El usuario ha sido agregado con éxito');
        Flasher::secondary('Declaración de seguridad para el módulo actual');
        Flasher::primary('Las cuentas de usuario permiten tener control de acceso al sistema.');
        Flasher::info('Recuerde capturar una contraseña segura');
        Flasher::danger('Funcionalidad limitada a usuarios especiales.');
        Flasher::warning('La acción que desea realizar puede provocar perdida de información.');
        Flasher::light('Alerta con estilo claro.');
        Flasher::dark('Alerta con estilo obscuro.');

        View::render('test');
    }
}

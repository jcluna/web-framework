# web-framework
Framework PHP para aplicaciones web

Este framework será desarrollado en PHP, trabajando con POO (Programación Orientada a Objetos); implementando el patrón MVC (Modelo-Vista-Controlador) y soportado por la base de datos MySql/MariaDb.

## Plan de Implementación

- Tecnicos
    - Crear clase para enviar correos de notificación

- Visuales
    - WaitMe
    - Notify o Toastr para notificación tipo toast
    - Logotipo y colores de identidad

## Plan Implementado
- Tecnicos
    - Contar con un archivo de configuración principal (web_config.php)
    - Contar con un archivo de configuración para la base de datos (web_config.php)
    - Todas las peticiones llegaran a index.php
    - Crear clase principal para iniciar una instancia del sistema
    - Crear clase para manejar vistas y renderizarlas
    - Crear clase para autocargar archivos y clases requeridas
    - Crear archivo de funciones independiente
    - Crear clase para redireccionar entre rutas
    - Crear clase para generar mensajes flash al usuario
    - Crear clase para realizar conexión a la base de datos
    - Registrar controlador y modelo principal
    - Crear clase para generar token de seguridad CSRF

- Visuales
    - Bootstrap 5 
    - FontAwesome 5 (uso de versión 6.*)
    - Requiere de una vista inicial para el sistema y una vista de error
    - Diseño simple y sencillo

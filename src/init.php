<?php
    //autoload
    spl_autoload_register(function ($class) {
        // Prefijo del namespace de tu proyecto
        $prefix = 'form\\';

        // Directorio base para el prefijo del namespace
        $base_dir = __DIR__ . '/../form/';

        // Verificar si la clase utiliza el prefijo del namespace
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            // No, sigue con el siguiente autoloader registrado
            return;
        }

        // Obtenemos el nombre de la clase sin el prefijo del namespace
        $relative_class = substr($class, $len);

        // Reemplaza los separadores de namespace por separadores de directorios en el nombre de la clase,
        // y añade el directorio base y la extensión .php
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        // Si el archivo existe, lo requerimos
        if (file_exists($file)) {
            require $file;
        }
    });
?>
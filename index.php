<?php

//autoload 
spl_autoload_register(function ($class) {

    $classPath = realpath("./");
    $file = str_replace('\\', '/', $class);
    $include = "$classPath/${file}.php";
    require($include);

});

$formulario = new claseMain\Formulario("index.php", claseMain\Formulario::METHOD_POST, "bbdd/bbdd.txt", array(
    //                                      =============== COMÚN ==================   //   ====== ESPECÍFICO ======
    //                   (null por defecto) valor    name            label                  placeholder     regex      
    $nombre = new tipoCampo\Text            (null, "nombre", "Introduce tu nombre",         "Tu nombre...", tipoCampo\Text::DEFAULT_PATTERN_25),
    $descripcion = new tipoCampo\Textarea   (null, "descripcion", "Introduce la desc",      "La desc...",   tipoCampo\Textarea::DEFAULT_PATTERN_500),
    //                                                                                                      tipoCampo                      MIN                              MAX
    $vecesVista = new tipoCampo\Numero      (null, "vistas", "¿Cuántas veces la viste?",    "0 - 10",       tipoCampo\Numero::TYPE_NUMBER, tipoCampo\Numero::MIN_DEFAULT_0, tipoCampo\Numero::MAX_10),
    //                                                                                      array (checkboxes)                                               
    $aficiones = new tipoCampo\Checkbox     (null, "aficiones", "Selecciona tus aficiones", ["dormir", "pintar", "deportes", "leer", "musica", "cinefilo", "otros"])
));

?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/index.css">
    <title>Formulario V2</title>
</head>
<body>
    <div class="main">
        <h1>Introduce tus datos</h1>
        <?php
            $formulario->pintarGlobal();
            $formulario->validarGuardar();
            if ($formulario->validarGlobal()) echo "validao en index";
        ?>
    </div>
</body>
</html>
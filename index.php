<?php

//autoload 
spl_autoload_register(function ($class) {

    $classPath = realpath("./");
    $file = str_replace('\\', '/', $class);
    $include = "$classPath/${file}.php";
    require($include);

});

//                                      ACTION      METHOD                              RUTA GUARDADO   CAMPOS
$formulario = new claseMain\Formulario("index.php", claseMain\Formulario::METHOD_POST, "bbdd/bbdd.txt", array(
    //                                      =================== COMÚN ================ // ======================== ESPECÍFICO ========================
    //            (null por defecto) valor    name            label                       tipoCampo              placeholder      regex
    $nombre = new campo\Texto        (null, "nombre", "Introduce tu nombre",              campo\Texto::TYPE_TEXT, "Tu nombre...",  campo\Texto::DEFAULT_PATTERN_25),
    $pass = new campo\Texto          (null, "contraseña", "Introduce tu contraseña",      campo\Texto::TYPE_PSWD, "Tu contra...",  campo\Texto::DEFAULT_PATTERN_25),
    $descripcion = new campo\Texto   (null, "descripcion", "Introduce la desc",           campo\Texto::TYPE_TAREA,"La desc...",    campo\Texto::DEFAULT_PATTERN_500),
    //                                                                                    tipoCampo                 MIN                          MAX
    $valoracion = new campo\Numero   (null, "valoracion", "Valoracion",                   campo\Numero::TYPE_RANGE, campo\Numero::MIN_DEFAULT_0, campo\Numero::MAX_10),
    $vecesVista = new campo\Numero   (null, "vistas", "¿Cuántas veces la viste?",         campo\Numero::TYPE_NUMBER, campo\Numero::MIN_DEFAULT_0, campo\Numero::MAX_10),
    //                                                                                    array (checkboxes, radios, selects)                                               
    $generos = new campo\Checkbox    (null, "generos", "¿De qué generos es?",             ["Comedia", "Terror", "Misterio", "Suspense", "Acción", "Otros"]),
    $emision = new campo\Radio       (null, "emision", "¿Está en emisión?",               ["Sí", "No"]),
    $plataforma = new campo\Select   (null, "plataforma", "¿En qué plataforma la viste?", ["Netflix","HBO","Piratilla","Otros"]),
    //                                                                                    f_ini             f_fin
    $fecha = new campo\Fecha         (null, "fecha", "Introduce la fecha",                campo\Fecha::NOW, campo\Fecha::PLUS_ONE_WEEK)
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
            if ($formulario->validarGlobal()) echo "¡Tu registro ha sido guardado!";
        ?>
        <br><br>
        <div class='text-center'><a href="listaSeries.php">Ver series registradas</a></div>
    </div>
</body>
</html>
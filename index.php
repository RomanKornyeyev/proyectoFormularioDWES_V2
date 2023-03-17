<?php

//autoload 
spl_autoload_register(function ($class) {
    $classPath = realpath("./");
    $file = str_replace('\\', '/', $class);
    $include = "$classPath/${file}.php";
    require($include);
});

// ================================= INICIALIZACIÓN DEL FORM =================================
//                                       ACTION                 METHOD                clases-css-form  CAMPOS
$formulario = new claseMain\Formulario("index.php", claseMain\Formulario::METHOD_POST, ["formulario"], array(
    //                                  ================================ COMÚN ================================ // ======================== ESPECÍFICO ========================
    //            (null por defecto) valor    name            label     clases-css-wrapper   clases-css-input          tipoCampo            placeholder              regex
    $nombre = new campo\Texto        (null, "nombre",       "Nombre",    ["input-wrapper"],  ["input"],         campo\Texto::TYPE_TEXT, "Tu nombre...",  campo\Texto::DEFAULT_PATTERN_25),
    $pass = new campo\Texto          (null, "contraseña",   "Password",  ["input-wrapper"],  ["input"],         campo\Texto::TYPE_PSWD, "Tu contra...",  campo\Texto::DEFAULT_PATTERN_25),
    $descripcion = new campo\Texto   (null, "descripcion",  "Descrip",   ["input-wrapper"],  ["input"],         campo\Texto::TYPE_TAREA,"La desc...",    campo\Texto::DEFAULT_PATTERN_500),
    //                                                                                                               tipoCampo                   min                         max
    $valoracion = new campo\Numero   (null, "valoracion", "Valoracion",  ["input-wrapper"],  ["input"],         campo\Numero::TYPE_RANGE, campo\Numero::MIN_DEFAULT_0, campo\Numero::MAX_10),
    $vecesVista = new campo\Numero   (null, "vistas",   "¿Veces vista?", ["input-wrapper"],  ["input"],         campo\Numero::TYPE_NUMBER, campo\Numero::MIN_DEFAULT_0, campo\Numero::MAX_10),
    //                                                                                                          clase-wrapper(chboxes)    tipoCampo                      array (checkboxes, radios, selects)                                               
    $generos = new campo\Multiple    (null, "generos",     "¿Géneros?",  ["input-wrapper"],  [""],              ["input-multiple"], campo\Multiple::TYPE_CHECKBOX, ["Comedia", "Terror", "Misterio", "Suspense", "Acción", "Otros"]),
    $emision = new campo\Multiple    (null, "emision",   "¿En emisión?", ["input-wrapper"],  [""],              ["input-multiple"], campo\Multiple::TYPE_RADIO,    ["Sí", "No"]),
    $plataforma = new campo\Multiple (null, "plataforma","¿Plataforma?", ["input-wrapper"],  [""],              ["input-multiple"], campo\Multiple::TYPE_SELECT,   ["Netflix","HBO","Piratilla","Otros"]),
    //                                                                                                                f_ini             f_fin
    $fecha = new campo\Fecha         (null, "fecha",        "Fecha",     ["input-wrapper"],  ["input"],         campo\Fecha::NOW, campo\Fecha::PLUS_ONE_WEEK),
    //                                                                                                          texto botón submit
    $submit = new campo\Submit       (null, "submit",        null,       ["input-wrapper"],  ["input"],         "ENVIAR")
));

//FUNCIONAL
// if ($formulario->validarGlobal()) echo "¡Tu registro ha sido guardado!";
// else if(isset($_POST['submit']) && !$formulario->validarGlobal()) echo "no válido!";

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
        <!-- pintar global lleva implicito los errores personalizados -->
        <?php $formulario->pintarGlobal(); ?>
        <br><br>
        <div class='text-center'><a href="listaSeries.php">Ver series registradas</a></div>
    </div>
</body>
</html>
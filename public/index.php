<?php

require("../src/init.php");
use form\campo\Atipo;
use form\campo\Fecha;
use form\campo\Multiple;
use form\campo\Numero;
use form\campo\Texto;
use form\claseMain\Formulario;


// ================================= INICIALIZACIÓN DEL FORM =================================
//                             ACTION            METHOD           clases-css-form  CAMPOS
$formulario = new Formulario("index.php", Formulario::METHOD_POST, ["formulario"], array(
    //                         ====================================== COMÚN ======================================  //  ======================== ESPECÍFICO ========================
    //                     ¿Puede estar vacío?  valor    name            label      clases-css-wrapper  clases-css-input      tipoCampo       placeholder         regex
    $nombre = new Texto        (Atipo::NULL_SI, null, "nombre",       "Nombre",    ["input-wrapper"],  ["input"],         Texto::TYPE_TEXT, "Tu nombre...",  Texto::DEFAULT_PATTERN_25),
    $pass = new Texto          (Atipo::NULL_SI, null, "contraseña",   "Password",  ["input-wrapper"],  ["input"],         Texto::TYPE_PSWD, "Tu contra...",  Texto::DEFAULT_PATTERN_25),
    $descripcion = new Texto   (Atipo::NULL_SI, null, "descripcion",  "Descrip",   ["input-wrapper"],  ["input"],         Texto::TYPE_TAREA,"La desc...",    Texto::DEFAULT_PATTERN_500),
    //                                                                                                                        tipoCampo            min                     max
    $valoracion = new Numero   (Atipo::NULL_SI, null, "valoracion", "Valoracion",  ["input-wrapper"],  ["input"],         Numero::TYPE_RANGE, Numero::MIN_DEFAULT_0, Numero::MAX_10),
    $vecesVista = new Numero   (Atipo::NULL_SI, null, "vistas",   "¿Veces vista?", ["input-wrapper"],  ["input"],         Numero::TYPE_NUMBER, Numero::MIN_DEFAULT_0, Numero::MAX_10),
    //                                                                                                                  clase-wrapper(chboxes)     tipoCampo                     array (checkboxes, radios, selects)                                               
    $generos = new Multiple    (Atipo::NULL_SI, null, "generos",     "¿Géneros?",  ["input-wrapper"],  [""],              ["input-multiple"], Multiple::TYPE_CHECKBOX, ["Comedia", "Terror", "Misterio", "Suspense", "Acción", "Otros"]),
    $emision = new Multiple    (Atipo::NULL_SI, null, "emision",   "¿En emisión?", ["input-wrapper"],  [""],              ["input-multiple"], Multiple::TYPE_RADIO,    ["Sí", "No"]),
    $plataforma = new Multiple (Atipo::NULL_SI, null, "plataforma","¿Plataforma?", ["input-wrapper"],  [""],              ["input-multiple"], Multiple::TYPE_SELECT,   ["Netflix","HBO","Piratilla","Otros"]),
    //                                                                                                                       f_ini             f_fin
    $fecha = new Fecha         (Atipo::NULL_SI, null, "fecha",        "Fecha",     ["input-wrapper"],  ["input"],         Fecha::NOW, Fecha::PLUS_ONE_WEEK)
// === SUBMIT ===
// claseWrappSubmit  idSubmit  nameSubm  txtSubmit  clseSubmit
), ["input-wrapper"], "enviar", "enviar", "ENVIAR", ["input"]);

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
        <!-- validación de campos (siempre por encima de pintarGlobal()) -->
        <?php 
            if ($formulario->validarGlobal()){
                // $formulario->vaciarCampos();
                echo "--- CORRECTO! =) ---";
            }else if(isset($_POST['enviar']) && !$formulario->validarGlobal()){
                echo "--- INCORRECTO!!! =( ---";
            }
        ?>
        <!-- pintar global lleva implicito los errores personalizados -->
        <?php $formulario->pintarGlobal(); ?>
        
        <br><br>
        <div class='text-center'><a href="listaSeries.php">Ver series registradas</a></div>
    </div>
</body>
</html>
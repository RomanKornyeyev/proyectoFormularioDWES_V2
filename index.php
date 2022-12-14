<?php

//autoload 
spl_autoload_register(function ($class) {

    $classPath = realpath("./");
    $file = str_replace('\\', '/', $class);
    //echo "FILE: ".$file."<br>";
    $include = "$classPath/${file}.php";
    //echo $include."<br>";
    require($include);

});

$formulario = new claseMain\Formulario("index.php", claseMain\Formulario::METHOD_POST, "bbdd/bbdd.txt", array(
    //                              valor   name    regex
    //                  (null por default)  
    $nombre = new tipoCampo\Text    (null, "nombre", tipoCampo\Text::DEFAULT_PATTERN_25),
    $apellido = new tipoCampo\Text  (null, "apellido", tipoCampo\Text::DEFAULT_PATTERN_25)
));

?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario V2</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        html{font-size: 62.5%;}
        body{font-size: 1.6rem; background-color: lightgray;}
        .main{
            width: 90%;
            max-width: 50rem;
            margin: 0 auto;
            padding: 1.5rem;
        }
        .formulario{
            display: flex;
            flex-flow: column;
            gap: 2rem;
            width: 100%;
        }
        input,textarea,button,select{
            border: none;
            outline: none;
            overflow: hidden;
        }
        textarea, input, button{
            padding: 15px;
            width: 100%;
            max-width: 100%;
            border: 1px solid gray;
        }
    </style>
</head>
<body>
    <div class="main">
        <?php
            $formulario->pintarGlobal();
            if ($formulario->validarGlobal()) echo "validao en index";
        ?>
    </div>
</body>
</html>
<?php

//autoload 
spl_autoload_register(function ($class) {

    $classPath = realpath("./");
    $file = str_replace('\\', '/', $class);
    $include = "$classPath/${file}.php";
    require($include);

});

$formulario = new claseMain\Formulario("index.php", Formulario::METHOD_POST, "bbdd/bbdd.txt", [
    //campo 1
    //campo 2
]);

?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario V2</title>
</head>
<body>
    
</body>
</html>
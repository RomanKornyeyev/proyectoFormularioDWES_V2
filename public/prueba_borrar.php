<?php
    echo "".implode("<br>", $_POST);
    echo "<br>";
    $_FILES['imagen']['full_path'] = "gazpacho2.jpg";
    echo "".$_FILES['imagen']['size'];
    if (isset($_FILES['imagen'])) {
        echo "SI, ESTÁ SETEADA<br>";
        print_r($_FILES['imagen']);
        echo $_POST['imagen'];
    }else{
        echo "NO, ESTÁ SETEADA";
    }
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
        <form action="" method="post" class="form-registro" enctype="multipart/form-data">
            <h1 class="titulo">REGÍSTRATE</h1>
            <!-- nombre -->
            <p class="input-wrapper">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="input" value="<?=$datos['nombre']?>">
                <?php if(isset($errores['nombre'])) echo $errores['nombre']."<br>" ?>
            </p>
            <!-- password -->
            <p class="input-wrapper">
                <label for="passwd">passwd:</label>
                <input type="password" name="passwd" id="passwd" class="input">
                <?php if(isset($errores['passwd'])) echo $errores['passwd']."<br>" ?>
            </p>
            <!-- correo -->
            <p class="input-wrapper">
                <label for="correo">correo:</label>
                <input type="text" name="correo" id="correo" class="input" value="<?=$datos['correo']?>">
                <?php if(isset($errores['correo'])) echo $errores['correo']."<br>" ?>
            </p>
            <!-- campo img -->
            <div class="input-wrapper flex-center-center gap-l">
                <div class="input-wrapper width-50">
                    <label for="imagen">Imagen: &nbsp;</label>
                    <input type="file" accept="image/png,image/jpeg" name="imagen" id="imagen"><br>
                </div>
            </div>

            <p class="input-wrapper">
                <button type="submit" name="enviar" class="btn btn--primary">REGISTRARME</button>
            </p>
            <p><a href="login.php">¿Ya tienes cuenta?</a></p>
        </form>
    </div>
</body>
</html>
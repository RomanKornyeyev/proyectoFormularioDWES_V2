<!-- Aquí imprimiremos los valores de bbdd.txt en una tabla.
También tendremos un botón para volver a la página de series.
Si nos sobra tiempo, añadiremos botones para eliminar series de esta lista.
Y la función de que te avise si hay capítulo de serie el día de la semana.-->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Estilos -->
    <link rel="stylesheet" href="styles/lista.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

    <!-- Bootrstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <title>Listado de Series</title>
</head>

<body>
    <div class="text-center p-3"><a href="index.php">Introducir otra serie</a></div>
    <div class="series">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Reseña</th>
                <th scope="col">Nota</th>
                <th scope="col">Veces vista</th>
                <th scope="col">Géneros</th>
                <th scope="col">¿En emisión?</th>
                <th scope="col">Plataforma</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $file = 'bbdd/bbdd.txt';
                $current = file_get_contents($file); //devuelve un string con toda la info del .txt
                $lista = explode("\n", $current); //divide las LÍNEAS de todo el string
                foreach ($lista as $value) {
                    if ($value != ""){ //la última línea está vacía, para evitar pintar otro tr y td, ponemos un if
                        echo "<tr>";
                        $linea = explode(";", $value);
                        foreach ($linea as $valor){ //divide CADA VALOR de la LÍNEA
                            if($valor != ""){
                                echo "<td>".$valor."</td>";
                            }
                        }
                        echo "<tr>";
                    }
                }
            ?>
        </tbody>
    </table>
    </div>
</body>

</html>
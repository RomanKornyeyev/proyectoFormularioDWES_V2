<?php

namespace claseMain;

class Formulario
{

    private $action; //action (ej: index.php)
    private $method; //método de envío (get o post)
    private $methodGlobal; //ARRAY de $_GET o $_POST (según method)
    private $rutaGuardado; //ruta para guardar el archivo
    private $campos = array();

    public const METHOD_POST = "post";
    public const METHOD_GET = "get";

    public function __construct($action = ".", $method = "get", $rutaGuardado = "./bbdd.txt", $campos = array()){
        $this->action = $action;
        $this->method = $method;
        $this->methodGlobal = ($this->method == self::METHOD_GET)? $_GET : $_POST;
        $this->rutaGuardado = $rutaGuardado;

        foreach ($campos as $campo) {
            (isset($this->methodGlobal[$campo->getName()]))? $campo->setValor($this->methodGlobal[$campo->getName()]) : $campo->setValor(null);
            array_push($this->campos, $campo);
        }
    }

    public function pintarGlobal(){
        //validamos para cargar la variable error y printearla
        $this->validarGlobal();

        //printeo del formulario
        echo "<form action='$this->action' method='$this->method' class='formulario'>";
        foreach ($this->campos as $campo) {
            echo "<div class='elemento'>";
            $campo->pintar(); //output: <input>
            echo "</div>";
        }
        echo "<div class='elemento'><input type='submit' name='submit' value='Enviar' class='submit'></div>";
        echo "</form>";
    }

    public function validarGlobal() : bool
    {
        $validado = false;

        if (isset($this->methodGlobal['submit'])) { //valida solo si se ha enviado el form
            $validado = true;
            foreach ($this->campos as $campo) {
                if (!$campo->validar()) {
                    $validado = false; //si un solo campo no está validado, devuelvo FALSE
                }
            }
        }

        return $validado;
    }

    //guardado en BD
    public function guardar(){

        // Path to the "DB"
        $file = $this->rutaGuardado;

        // Open the file to get existing content
        $current = file_get_contents($file);

        // Append a new series to the file
        foreach ($this->methodGlobal as $key => $value) {
            //GUARDA TODOS LOS PARÁMETROS MENOS EL SUBMIT (botón submit)
            if ($key != 'submit' ) {
                //si no es checkbox (no es un array, recibe UNA opción)
                if (!is_array($value)) {
                    $current .= $value . ";";
                //si es checkbox (es un array, recibe varias opciones)
                } else {
                    foreach ($value as $val) {
                        $current .= $val." ";
                    }
                    $current .= ";";
                }
            } 
        }
        $current .= "\n";

        // Write the contents back to the file
        file_put_contents($file, $current);
    }

    public function validarGuardar(){
        if ($this->validarGlobal()) {
            $this->guardar();
        }
    }

}


?>
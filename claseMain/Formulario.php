<?php

namespace claseMain;

use tipoCampo\Text;

class Formulario
{

    private $action;
    private $method;
    private $rutaGuardado;
    private $campos;

    public const METHOD_POST = "post";
    public const METHOD_GET = "get";

    public function __construct($action = ".", $method = "get", $rutaGuardado = "./bbdd.txt", $campos = []){
        $this->action = $action;
        $this->$method = $method;
        $this->$rutaGuardado = $rutaGuardado;
        $this->$campos = $campos; //ARRAY CON LOS CAMPOS
    }

    public function pintarGlobal(){
        echo "<form action='$this->action' method='$this->method'>";
        foreach ($this->campos as $campo) {
            echo "<div>";
            $campo->pintar();
            echo "</div>";
        }
        echo "<div><input type='submit' name='submit' value='Enviar' class='submit'></div>"
        echo "</form>";
    }

    public function validarGlobal(){
        ($this->method == self::METHOD_GET)? $varGlobal = '$_POST' : $varGlobal = '$_GET';

        $validado = true;

        if (isset($varGlobal['submit'])) {
            foreach ($this->campos as $campo) {
                if (isset($varGlobal[$campo->getName()])) {
                    
                }
                $campo->validarEspecifico();
            }
        }
    }

    //guardado en BD
    public function guardar(){

        // Path to the "DB"
        $file = $this->$rutaGuardado;

        // Open the file to get existing content
        $current = file_get_contents($file);

        // Append a new series to the file
        foreach ($post as $key => $value) {
            //GUARDA TODOS LOS PARÁMETROS MENOS EL SUBMIT (botón submit)
            if ($key != 'submit' ) {
                //si no es checkbox (no es un array, recibe una opción)
                if (!is_array($value)) {
                    $current .= $value . ";";
                //si es checkbox (es un array, recibe varias opciones)
                } else {
                    foreach ($post['generos'] as $genero) {
                        $current .= $genero." ";
                    }
                    $current .= ";";
                }
            } 
        }
        $current .= "\n";

        // Write the contents back to the file
        file_put_contents($file, $current);

    }



}


?>
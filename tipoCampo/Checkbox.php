<?php

namespace claseMain;

use \tipoCampo\Text;

class Formulario
{

    private $action;
    private $method;
    private $methodGlobal; //ARRAY $_GET o $_POST
    private $rutaGuardado;
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
        // foreach ($campos as $campo) {
        //     array_push($this->campos, $campo);
        // }
        //$this->campos = $campos; //ARRAY CON LOS CAMPOS
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

    // public function validarGuardar(){
    //     if ($this->validarGlobal()) {
    //         $this->guardar();
    //     }
    // }

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

}


?>
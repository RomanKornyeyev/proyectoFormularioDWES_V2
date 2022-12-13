<?php

namespace claseMain;

use \tipoCampo\Text;

class Formulario
{

    private $action;
    private $method;
    private $rutaGuardado;
    private $campos = array();

    public const METHOD_POST = "post";
    public const METHOD_GET = "get";

    public function __construct($action = ".", $method = "get", $rutaGuardado = "./bbdd.txt", $campos = array()){
        $this->action = $action;
        $this->$method = $method;
        $this->$rutaGuardado = $rutaGuardado;

        // $varGlobal = ($this->method == self::METHOD_GET)? '$_POST' : '$_GET';
        // foreach ($campos as $campo) {
        //     $campo->getValue() = isset($varGlobal[$campo->getName()])? $varGlobal[$campo->getName()] : null;
        //     array_push($this->$campos, );
        // }
        foreach ($campos as $campo) {
            array_push($this->campos, $campo);
        }
        //array_push($this->campos, $campos[0]);
        //$this->$campos = $campos; //ARRAY CON LOS CAMPOS
    }

    public function pintarGlobal(){
        echo "<form action='$this->action' method='$this->method'>";
        foreach ($this->campos as $campo) {
            echo "<div>";
            $campo->pintar();
            echo "</div>";
        }
        echo "<div><input type='submit' name='submit' value='Enviar' class='submit'></div>";
        echo "</form>";


        //print_r($this->campos);
    }

    // public function validarGuardar(){
    //     if ($this->validarGlobal()) {
    //         $this->guardar();
    //     }
    // }

    public function validarGlobal() : bool
    {
        $varGlobal = ($this->method == self::METHOD_GET)? '$_POST' : '$_GET';
        $validado = true;

        if (isset($varGlobal['submit'])) {
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
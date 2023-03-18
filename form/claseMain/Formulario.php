<?php

namespace form\claseMain;

class Formulario
{

    private $action; //action (ej: index.php)
    private $method; //método de envío (get o post)
    private $methodGlobal; //ARRAY de $_GET o $_POST (según method), OJO, ES EL ARRAY de $_GET/$_POST, NO EL MÉTODO QUE SE UTILIZA
    private $claseForm = array(); //ARRAY de clases (css) del form
    private $campos = array(); //ARRAY de campos

    private $claseSubmitWrapper = array();
    private $idSubmit;
    private $nameSubmit;
    private $valorSubmit;
    private $claseSubmitInput = array();

    public const METHOD_POST = "post";
    public const METHOD_GET = "get";

    public function __construct(
        $action = ".",
        $method = self::METHOD_POST,
        $claseForm = array("formulario"),
        $campos = array(),
        $claseSubmitWrapper = array(""),
        $idSubmit = "",
        $nameSubmit = "submit",
        $valorSubmit = "submit",
        $claseSubmitInput = array(""))
    {
        $this->action = $action;
        $this->method = $method;
        $this->claseForm = $claseForm;
        $this->methodGlobal = ($this->method == self::METHOD_GET)? $_GET : $_POST;

        $this->claseSubmitWrapper = $claseSubmitWrapper;
        $this->idSubmit = $idSubmit;
        $this->nameSubmit = $nameSubmit;
        $this->valorSubmit = $valorSubmit;
        $this->claseSubmitInput = $claseSubmitInput;

        foreach ($campos as $campo) {
            (isset($this->methodGlobal[$campo->getName()]))? $campo->setValor($this->methodGlobal[$campo->getName()]) : $campo->setValor(null);
            array_push($this->campos, $campo);
        }
    }

    public function getMethodGlobal() { return $this->methodGlobal; }

    public function pintarGlobal(){
        //validamos para cargar la variable error y printearla
        $this->validarGlobal();

        //vaciado de campos si están validados, útil si queremos insertar más entradas en una misma página
        if ($this->validarGlobal()) {
            $this->vaciarCampos();
        }

        //printeo del formulario
        echo "<form action='$this->action' method='$this->method' class='".implode(" ", $this->claseForm)."'>\n";
        foreach ($this->campos as $campo) {
            echo "<div class='".implode(" ", $campo->getClaseWrapper())."'>\n";
            $campo->pintar(); //output: <input>
            echo "</div>\n";
        }
        echo "<div class='".implode(" ", $this->claseSubmitWrapper)."'>\n";
        echo "<input type='submit' id='$this->idSubmit' name='$this->nameSubmit' value='$this->valorSubmit' class='".implode(" ", $this->claseSubmitInput)."'>\n";   
        echo "</div>\n";
        echo "</form>\n";
    }

    public function validarGlobal() : bool
    {
        $validado = false;

        if (isset($this->methodGlobal[$this->nameSubmit])) { //valida solo si se ha enviado el form
            $validado = true;
            foreach ($this->campos as $campo) {
                if (!$campo->validar()) {
                    $validado = false; //si un solo campo no está validado, devuelvo FALSE
                }
            }
        }

        return $validado;
    }

    public function vaciarCampos(){
        // --- VACIADO CON JS (LEGACY) xd me creo guay por poner legacy en vez de antiguo ---
        //IMP: solo sirve para texto y numeros. No va para multiple y fecha, de momento no es necesario
        //si el form está validad, vacía los campos
        // if($this->validarGlobal()){
        //     echo "<script>";
        //     foreach ($this->campos as $campo) {
        //         echo "document.getElementById('".$campo->getName()."').value='';";
        //     }
        //     echo "</script>";
        // }
        if($this->validarGlobal()){
            foreach ($this->campos as $campo) {
                $campo->setValor("");
            }
        }
        
    }
}


?>
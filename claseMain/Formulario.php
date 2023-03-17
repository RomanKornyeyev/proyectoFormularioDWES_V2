<?php

namespace claseMain;

class Formulario
{

    private $action; //action (ej: index.php)
    private $method; //método de envío (get o post)
    private $methodGlobal; //ARRAY de $_GET o $_POST (según method), OJO, ES EL ARRAY de $_GET/$_POST, NO EL MÉTODO QUE SE UTILIZA
    private $claseForm = array(); //ARRAY de clases (css) del form
    private $campos = array(); //ARRAY de campos

    public const METHOD_POST = "post";
    public const METHOD_GET = "get";

    public function __construct($action = ".", $method = self::METHOD_POST, $claseForm = array("formulario"), $campos = array()){
        $this->action = $action;
        $this->method = $method;
        $this->claseForm = $claseForm;
        $this->methodGlobal = ($this->method == self::METHOD_GET)? $_GET : $_POST;

        foreach ($campos as $campo) {
            (isset($this->methodGlobal[$campo->getName()]))? $campo->setValor($this->methodGlobal[$campo->getName()]) : $campo->setValor(null);
            array_push($this->campos, $campo);
        }
    }

    public function pintarGlobal(){
        //validamos para cargar la variable error y printearla
        $this->validarGlobal();

        //printeo del formulario
        echo "<form action='$this->action' method='$this->method' class='".implode(" ", $this->claseForm)."'>";
        foreach ($this->campos as $campo) {
            echo "<div class='".implode(" ", $campo->getClaseWrapper())."'>";
            $campo->pintar(); //output: <input>
            echo "</div>";
        }
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
}


?>
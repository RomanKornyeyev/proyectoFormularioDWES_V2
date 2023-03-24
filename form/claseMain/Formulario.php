<?php

namespace form\claseMain;

class Formulario
{
    //action, campos, etc.
    private $action; //action (ej: index.php)
    private $method; //método de envío (get o post)
    private $methodGlobal; //ARRAY de $_GET o $_POST (según method), OJO, ES EL ARRAY de $_GET/$_POST, NO EL MÉTODO QUE SE UTILIZA
    private $claseForm = array(); //ARRAY de clases (css) del form
    private $vaciar;
    private $atr;
    private $campos = array(); //ARRAY de campos
    
    //submit
    private $claseSubmitWrapper = array();
    private $idSubmit;
    private $nameSubmit;
    private $valorSubmit;
    private $claseSubmitInput = array();

    public const METHOD_POST = "post";
    public const METHOD_GET = "get";

    public const VACIAR_SI = 1;
    public const VACIAR_NO = 0;

    public const ATR_IMG = "enctype='multipart/form-data'";

    public function __construct(
        $action = ".",
        $method = self::METHOD_POST,
        //methodGlobal va auto (respecto al method)
        $claseForm = array("formulario"),
        $vaciar = self::VACIAR_SI,
        $atr = "",
        $campos = array(),
        $claseSubmitWrapper = array(""),
        $idSubmit = "",
        $nameSubmit = "submit",
        $valorSubmit = "submit",
        $claseSubmitInput = array(""))
    {
        $this->action = $action;
        $this->method = $method;
        $this->methodGlobal = ($this->method == self::METHOD_GET)? $_GET : $_POST;
        $this->claseForm = $claseForm;
        $this->vaciar = $vaciar;
        $this->atr = $atr;

        foreach ($campos as $campo) {
            (isset($this->methodGlobal[$campo->getName()]))? $campo->setValor($this->methodGlobal[$campo->getName()]) : $campo->setValor($campo->getValor());
            array_push($this->campos, $campo);
        }

        $this->claseSubmitWrapper = $claseSubmitWrapper;
        $this->idSubmit = $idSubmit;
        $this->nameSubmit = $nameSubmit;
        $this->valorSubmit = $valorSubmit;
        $this->claseSubmitInput = $claseSubmitInput;
    }

    public function getMethodGlobal() { return $this->methodGlobal; }

    public function pintarGlobal(){
        //validamos para cargar la variable error y printearla
        $this->validarGlobal();

        //si está solicitado
        if ($this->vaciar == self::VACIAR_SI) {
            //vaciado de campos si están validados, útil si queremos insertar más entradas en una misma página
            if ($this->validarGlobal()) {
                $this->vaciarCampos();
            }
        }

        //guarda imgs si valida
        // if ($this->validarGlobal()) {
        //     $this->guardarArchivos();
        // }
        
        //printeo del formulario
        echo "<form action='$this->action' method='$this->method' class='".implode(" ", $this->claseForm)."' $this->atr>\n";
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
        foreach ($this->campos as $campo) {
            $campo->setValor("");
        }
    }

    // public function guardarArchivos(){
    //     foreach ($this->campos as $campo) {
    //         if (isset($_FILES[$campo->getName()])) {
    //             move_uploaded_file($_FILES[$campo->getName()]['tmp_name'], $campo->getRuta());
    //         }
    //     }
    // }
}


?>
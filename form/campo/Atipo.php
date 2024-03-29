<?php

namespace form\campo;

abstract class Atipo
{    
    protected $null; //¿El campo puede estar vacío?
    protected $valor; //valor del campo enviado
    protected $name; //name en HTML
    protected $label; //texto del label
    protected $error; //error personalizado por cada campo
    protected $claseWrapper = array(); //clases CSS personalizada para el div que envuelve el input+label+error
    protected $claseInput = array(); //clases CSS personalizada para el input
    

    public const NULL_SI = 1;
    public const NULL_NO = 0;

    public function __construct($null = self::NULL_NO, $valor = "", $name = "", $label = "", $claseWrapper = array("input-wrapper"), $claseInput = array("input")) {
        $this->null = $null;
        $this->valor = $valor;
        $this->name = $name;
        $this->label = $label;
        $this->claseWrapper = $claseWrapper;
        $this->claseInput = $claseInput;
    }

    public function getValor() { return $this->valor; }
    public function setValor($valor) { $this->valor = $valor; }
    public function getName() { return $this->name; }
    public function getClaseWrapper() { return $this->claseWrapper;}

    //devuelve true si el valor no es nulo ni está vacío + validaciones específicas de cada tipo
    public function validar(){    
        //si el campo no está vacío o PUEDE SER NULL/VACÍO
        if (($this->valor != "" && $this->valor != null) || ($this->null == self::NULL_SI)) {
            return $this->validarEspecifico();
        //si el campo no está vacío y NO PUEDE SER NULL/VACÍO
        } else{
            $this->error = "El campo $this->name no puede estar vacío<br>";
            return false;
        }
    }
    
    //imprimir el error (en caso de que exista)
    public function imprimirError(){
        if ($this->error != null) echo "<div class='error'>$this->error</div>";
    }

    //limpieza de carácteres especiales HTML para evitar cross-site scripting
    function cleanData($data){
        if (is_string($data)) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        } else {
            return $data;
        }
    }

    abstract public function pintar(); //A rellenar en la clase específica

    abstract public function validarEspecifico(); //A rellenar en la clase específica
}
?>
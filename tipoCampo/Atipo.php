<?php
namespace tipoCampo;

abstract class Atipo
{    
    protected $valor; //valor del campo enviado
    protected $name; //name en HTML
    protected $error; //error personalizado por cada campo

    public function __construct($valor = "", $name = "") {
        $this->valor = $valor;
        $this->name = $name;
    }

    public function getValor() { return $this->valor; }
    public function getName() { return $this->name; }

    //devuelve true si el valor no es nulo ni está vacío + validaciones específicas de cada tipo
    public function validar(){        
        if ($this->valor != "" && $this->valor != null) {
            return $this->validarEspecifico();
        } else {
            $this->error = "El campo $this->name no puede estar vacío<br>";
            return false;
        }
    }
    
    //imprimir el error (en caso de que exista)
    public function imprimirError(){
        if ($this->error != null) echo "<div class='error'>$this->error</div>";
    }

    abstract public function pintar(); //A rellenar en la clase específica

    abstract public function validarEspecifico(); //A rellenar en la clase específica
}
?>
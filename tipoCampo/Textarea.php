<?php
namespace tipoCampo;

class Textarea extends Atipo
{
    private $placeholder;
    private $patron;

    //letras mayus y minus, números, comas, puntos, exlamaciones e interrogaciones, guiones y barras bajas
    public const DEFAULT_PATTERN_500 = "/^[a-zA-Z0-9\s\,\.\¿\?\¡\!\_\-]{1,500}$/";

    public function __construct($valor, $name, $label, $placeholder, $patron){
        parent::__construct($valor,$name,$label);
        $this->placeholder = $placeholder;
        $this->patron = $patron;
    }
    
    function validarEspecifico(){
        //si el valor (texto introducido por el user) limpiado con cleanData coincide con el patrón, devuelve true
        //en caso contrario, devuelve false y carga error con el mensaje personalizado
        if (preg_match($this->patron, $this->cleanData($this->valor))){
            return true;
        }else {
            $this->error = "No se admiten carácteres especiales y el tamaño máximo es de 500 caracteres<br>";
            return false;
        }
    }

    function pintar(){
        //label, input y error
        echo "<label for='" . $this->name . "'>" . $this->label . "</label>";
        echo "<textarea id='" . $this->name . "' name='" . $this->name . "' placeholder='$this->placeholder' rows='8' cols='50'>$this->valor</textarea>";
        $this->imprimirError();
    }
}

?>
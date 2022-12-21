<?php
namespace campo;

class Texto extends Atipo
{
    private $tipo;
    private $placeholder;
    private $patron;

    //letras mayus y minus, números, comas, puntos, exlamaciones e interrogaciones, guiones y barras bajas
    public const DEFAULT_PATTERN_25 = "/^[a-zA-Z0-9\s\,\.\¿\?\¡\!\_\-]{1,25}$/";
    public const DEFAULT_PATTERN_500 = "/^[a-zA-Z0-9\s\,\.\¿\?\¡\!\_\-]{1,500}$/";

    public const TYPE_TEXT = "text";
    public const TYPE_TAREA = "textarea";
    public const TYPE_PSWD = "password";

    public function __construct($valor, $name, $label, $tipo = self::TYPE_TEXT, $placeholder, $patron = self::DEFAULT_PATTERN_25){
        parent::__construct($valor,$name,$label);
        $this->tipo = $tipo;
        $this->placeholder = $placeholder;
        $this->patron = $patron;
    }
    
    function validarEspecifico(){
        //si el valor (texto introducido por el user) limpiado con cleanData coincide con el patrón, devuelve true
        //en caso contrario, devuelve false y carga error con el mensaje personalizado
        if (preg_match($this->patron, $this->cleanData($this->valor))){
            return true;
        }else {
            $longitud = ($this->tipo == self::TYPE_TAREA)? 500 : 25;
            $this->error = "No se admiten carácteres especiales y el tamaño máximo es de $longitud caracteres<br>";
            return false;
        }
    }

    function pintar(){
        //label, input y error
        echo "<label for='" . $this->name . "'>" . $this->label . "</label>";
        if ($this->tipo == self::TYPE_TAREA)
            echo "<textarea id='" . $this->name . "' name='" . $this->name . "' placeholder='$this->placeholder' rows='8' cols='50'>$this->valor</textarea>";
        else
            echo "<input type='$this->tipo' id='" . $this->name . "' name='" . $this->name . "' placeholder='$this->placeholder' value='" . $this->valor . "'>";
        
        $this->imprimirError();
    }
}

?>
<?php
namespace campo;

class Text extends Atipo
{
    private $placeholder;
    private $tipo;
    private $patron;

    //letras mayus y minus, números, comas, puntos, exlamaciones e interrogaciones, guiones y barras bajas
    public const DEFAULT_PATTERN_25 = "/^[a-zA-Z0-9\s\,\.\¿\?\¡\!\_\-]{1,25}$/";

    public const TYPE_TEXT = "text";
    public const TYPE_PSWD = "password";

    public function __construct($valor, $name, $label, $placeholder, $tipo, $patron){
        parent::__construct($valor,$name,$label);
        $this->placeholder = $placeholder;
        $this->tipo = $tipo;
        $this->patron = $patron;
    }
    
    function validarEspecifico(){
        //si el valor (texto introducido por el user) limpiado con cleanData coincide con el patrón, devuelve true
        //en caso contrario, devuelve false y carga error con el mensaje personalizado
        if (preg_match($this->patron, $this->cleanData($this->valor))){
            return true;
        }else {
            $this->error = "No se admiten carácteres especiales y el tamaño máximo es de 25 caracteres<br>";
            return false;
        }
    }

    function pintar(){
        //label, input y error
        echo "<label for='" . $this->name . "'>" . $this->label . "</label>";
        echo "<input type='$this->tipo' id='" . $this->name . "' name='" . $this->name . "' placeholder='$this->placeholder' value='" . $this->valor . "'>";
        $this->imprimirError();
    }
}

?>
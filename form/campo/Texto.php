<?php

namespace form\campo;

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
    public const TYPE_HIDDEN = "hidden";

    public function __construct($null,$valor, $name, $label, $claseWrapper, $claseInput, $tipo = self::TYPE_TEXT, $placeholder, $patron = self::DEFAULT_PATTERN_25){
        parent::__construct($null,$valor,$name,$label,$claseWrapper,$claseInput);
        $this->tipo = $tipo;
        $this->placeholder = $placeholder;
        $this->patron = $patron;
    }
    
    function validarEspecifico(){
        //si el valor (texto introducido por el user) limpiado con cleanData coincide con el patrón, devuelve true
        //en caso contrario, devuelve false y carga error con el mensaje personalizado
        //si está vacío y puede estarlo, devuelveme true
        if (preg_match($this->patron, $this->cleanData($this->valor)) || (($this->valor == null || $this->valor == "") && ($this->null == Atipo::NULL_SI))){
            return true;
        }else {
            $longitud = ($this->tipo == self::TYPE_TAREA)? 500 : 25;
            $this->error = "No se admiten carácteres especiales y el tamaño máximo es de $longitud caracteres<br>";
            return false;
        }
    }

    function pintar(){
        echo "<label for='$this->name'>$this->label</label>\n";
        if ($this->tipo == self::TYPE_TAREA){
            echo "<textarea id='$this->name' name='$this->name' placeholder='$this->placeholder' rows='8' cols='50' class='".implode(" ", $this->claseInput)."'>$this->valor</textarea>\n";
        }else{
            //si es un input tipo password, no guarda los datos
            ($this->tipo != self::TYPE_PSWD)? $this->valor = $this->valor : $this->valor = "";
            echo "<input type='$this->tipo' id='$this->name' name='$this->name' placeholder='$this->placeholder' value='$this->valor' class='".implode(" ", $this->claseInput)."'>\n";
        }
        $this->imprimirError();
        
    }
}

?>
<?php
namespace tipoCampo;

class Text extends Atipo
{
    private $placeholder;
    private $patron;

    //constantes públicas para poder utilizarse fuera
    //letras mayus y minus, números, comas, puntos, exlamaciones e interrogaciones, guiones y barras bajas
    public const DEFAULT_PATTERN_25 = "/^[a-zA-Z0-9\s\,\.\¿\?\¡\!\_\-]{1,25}$/";

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
            $this->error = "No se admiten carácteres especiales y el tamaño máximo es de 25 caracteres<br>";
            return false;
        }
    }

    function pintar(){
        //label, input y error
        echo "<label for='" . $this->name . "'>" . $this->label . "</label>";
        echo "<input type='text' id='" . $this->name . "' name='" . $this->name . "' placeholder='$this->placeholder' value='" . $this->valor . "'>";
        $this->imprimirError();
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

}

?>
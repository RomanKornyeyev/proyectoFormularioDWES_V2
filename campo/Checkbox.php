<?php

namespace campo;

class Checkbox extends Atipo
{
    private $arr = [];

    public function __construct($valor, $name, $label, $arr = []){
        parent::__construct($valor,$name,$label);
        foreach ($arr as $valor){
            array_push($this->arr, $valor);
        }
    }

    public function validarEspecifico(){
        $esValido = true;
        //si uno de los valores del checkbox no es válido, la validación devuelve false
        foreach ($this->valor as $val) {
            if (!(in_array($val, $this->arr)))
                $esValido = false;
        }
        $esValido ? $this->error = "" : $this->error = "¡No modifiques los valores del checkbox!";
        return $esValido;
    }


    public function pintar(){
        echo "<label for='" . $this->name . "'>" . $this->label . "</label>";
        $checked ="";
        echo "<div class='checkbox'>";
        foreach ($this->arr as $value) {
            //por cada input checkbox, comprueba que el valor NO ESTÉ MARCADO
            if(!empty($this->getValor()))
                //si no lo está, no lo marca, si lo está lo marca (check)
                (in_array($value, $this->getValor())) ? $checked = "checked" : $checked = "";

            echo "<label for='".$value."'>$value</label> <input type='checkbox' id='$value' name='".$this->getName()."[]' value='$value' $checked >";
        }
        echo "</div>";
        //error personalizado impreso debajo del div
        $this->imprimirError();
    }
}

?>
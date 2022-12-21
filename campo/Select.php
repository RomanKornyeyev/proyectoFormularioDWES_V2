<?php

namespace campo;

class Select extends Atipo
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

        //radio devuelve un único String, comprobamos que ese String devuelto esté en el array con el que se inicializó
        if (in_array($this->valor, $this->arr)) {
            $esValido = true;
            $this->error = "";
        }else{
            $esValido = false;
            $this->error = "¡No modifiques los valores de la lista!";
        }
        return $esValido;
    }


    public function pintar(){
        echo "<label for='".$this->name."'>".$this->label.":</label><br>";
        echo "<select id='".$this->name."' name='".$this->name."'>";
        $selected = "";
        foreach ($this->arr as $value) {
            //comprueba que esté seleccionado y lo deja seleccionado si lo estaba
            ($this->getValor() == $value) ? $selected = "selected" : $selected = "";
            echo "<option value='$value' $selected > $value </option>";
        }
        echo '</select>';

        //error personalizado impreso debajo del div
        $this->imprimirError();
    }
}

?>
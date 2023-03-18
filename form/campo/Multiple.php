<?php

namespace form\campo;

class Multiple extends Atipo
{
    private $claseMultiple = array();
    private $tipo;
    private $arr = [];

    public const TYPE_CHECKBOX = "checkbox";
    public const TYPE_RADIO = "radio";
    public const TYPE_SELECT = "select";

    public function __construct($null,$valor,$name,$label,$claseWrapper,$claseInput,$claseMultiple=array(""),$tipo=self::TYPE_CHECKBOX,$arr = []){
        parent::__construct($null,$valor,$name,$label,$claseWrapper,$claseInput);
        $this->claseMultiple = $claseMultiple;
        $this->tipo = $tipo;
        foreach ($arr as $valor){
            array_push($this->arr, $valor);
        }
    }

    public function validarEspecifico(){
        $esValido = true;

        //--- si es checkbox ---
        if ($this->tipo == "checkbox") {
            //si uno de los valores del checkbox no es válido, la validación devuelve false
            foreach ($this->valor as $val) {
                //si el valor está vacío y puede estar vacío
                if (($this->valor == null || $this->valor == "") && ($this->null == Atipo::NULL_SI)) {
                    $esValido = true;
                }else{
                    if (!(in_array($val, $this->arr)))
                    $esValido = false;
                }
            }
            $esValido ? $this->error = "" : $this->error = "¡No modifiques los valores del checkbox!";
        //si es radio/select
        }else{
           //radio devuelve un único String, comprobamos que ese String devuelto esté en el array con el que se inicializó
           //si puede ser null/vacío o el valor se encuentra en el array, devuelveme TRUE
            if ((($this->valor == null || $this->valor == "") && ($this->null == Atipo::NULL_SI)) || in_array($this->valor, $this->arr)) {
                $esValido = true;
                $this->error = "";
            }else{
                $esValido = false;
                $this->error = "¡No modifiques los valores de la lista!";
            } 
        }
        
        return $esValido;
    }


    public function pintar(){
        echo "<label for='$this->name'>$this->label</label>\n";

        // --- si es checkbox --- 
        if ($this->tipo == "checkbox") {
            $checked ="";
            echo "<div class='".implode(" ", $this->claseMultiple)."'>\n";
            foreach ($this->arr as $value) {
                //por cada input checkbox, comprueba que el valor NO ESTÉ MARCADO
                if(!empty($this->valor))
                    //si no lo está, no lo marca, si lo está lo marca (check)
                    (in_array($value, $this->valor)) ? $checked = "checked" : $checked = "";

                echo "<label for='$value'>$value</label>\n <input type='checkbox' id='$value' class='".implode(" ", $this->claseInput)."' name='".$this->getName()."[]' value='$value' $checked >\n";
            }
            echo "</div>\n";
        // --- si es radio --- 
        }else if($this->tipo == "radio"){
            echo "<div class='".implode(" ", $this->claseMultiple)."'>\n";
            $checked ="";
            foreach ($this->arr as $value) {
                //comprueba que esté seleccionado y lo deja seleccionado si lo estaba
                ($this->valor == $value) ? $checked = "checked" : $checked = "";
                echo "<input type='radio' id='$value' class='".implode(" ", $this->claseInput)."' name='$this->name' value='$value' $checked>\n";
                echo "<label for='$value'>$value</label><br>\n";
            }
            echo "</div>\n";
        // --- si es select ---
        }else{
            echo "<select id='$this->name' class='".implode(" ", $this->claseInput)."' name='$this->name'>\n";
            $selected = "";
            foreach ($this->arr as $value) {
                //comprueba que esté seleccionado y lo deja seleccionado si lo estaba
                ($this->valor == $value) ? $selected = "selected" : $selected = "";
                echo "<option value='$value' $selected>$value</option>\n";
            }
            echo "</select>\n";
        }

        //error personalizado
        $this->imprimirError();
    }
}

?>
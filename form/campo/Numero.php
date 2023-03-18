<?php

namespace form\campo;

class Numero extends Atipo {

    private $tipo;
    private $min;
    private $max;

    public const TYPE_RANGE="range";
    public const TYPE_NUMBER="number";

    public const MIN_DEFAULT_0=0;
    public const MAX_5=5;
    public const MAX_10=10;
    public const MAX_15=15;

    public function __construct($null,$valor,$name,$label,$claseWrapper,$claseInput,$tipo=self::TYPE_NUMBER,$min=self::MIN_DEFAULT_0,$max=self::MAX_10) {
        parent::__construct($null,$valor,$name,$label,$claseWrapper,$claseInput);
        $this->tipo = $tipo;
        $this->min = $min;
        $this->max = $max;
    }

    function validarEspecifico () {
        //si el valor está en el rango permitido o si el valor es null/vacío y puede ser null/vacío, validamelo
        if (($this->valor>=$this->min && $this->valor<=$this->max) || ($this->null == Atipo::NULL_SI && ($this->valor == "" || $this->valor == null))){
            return true;
        }else{
            $this->error="Fuera del rango permitido, debe estar entre $this->min y $this->max (ambos incluidos).";
            return false;
        }   
    }

    function pintar() {
        echo "<label for='$this->name'>$this->label</label>";
        echo "<input type='$this->tipo' id='$this->name' name='$this->name' min='$this->min' max='$this->max' value='$this->valor' placeholder='$this->min - $this->max' class='".implode(" ", $this->claseInput)."'>";
        $this->imprimirError();
    }
}
?>
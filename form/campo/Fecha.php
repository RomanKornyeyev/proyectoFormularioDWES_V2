<?php

namespace form\campo;

class Fecha extends Atipo
{

    private $inicio;
    private $fin;

    public const NOW = "now";
    public const PLUS_ONE_WEEK = "+1 week";

    public function __construct($null, $valor, $name, $label, $claseWrapper, $claseInput, $inicio = self::NOW, $fin = self::PLUS_ONE_WEEK){
        parent::__construct($null,$valor,$name,$label,$claseWrapper,$claseInput);
        $this->inicio = strtotime($inicio);
        $this->fin = strtotime($fin);
    }
    
    function validarEspecifico () {       
        //el campo date en HTML te coge solo YYYY/MM/DD, NO COGE LAS HORAS
        //esto nos puede dar error al compararlo con strtotime("now") y otras fechas
        //para evitar estos problemas, añadimos la hora de envío de la fecha seleccionada por el usuario 
        if (strtotime($this->valor.date("H:i:s"))>=$this->inicio && strtotime($this->valor.date("H:i:s"))<=$this->fin){
            return true;
        }else{
            $this->error="Fuera del rango permitido, debe estar entre ".date("Y-m-d", $this->inicio)." y ".date("Y-m-d", $this->fin)." (ambos incluidos).";
            return false;
        }   
    }

    function pintar(){
        //label, input y error
        echo "<label for='$this->name'>$this->label (entre ".date("Y-m-d", $this->inicio)." y ".date("Y-m-d", $this->fin).")</label>";
        echo "<input type='date' id='$this->name' name='$this->name' value='$this->valor' class='".implode(" ", $this->claseInput)."'>";
        $this->imprimirError();
    }
}

?>
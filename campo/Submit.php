<?php

namespace campo;

class Submit extends Atipo {

    private $valorSubmit;

    public function __construct($valor,$name,$label,$claseWrapper,$claseInput,$valorSubmit="submit") {
        parent::__construct($valor,$name,$label,$claseWrapper,$claseInput);
        $this->valorSubmit=$valorSubmit;
    }

    function validarEspecifico(){
        //si el valor (texto introducido por el user) limpiado con cleanData coincide con el patrón, devuelve true
        //en caso contrario, devuelve false y carga error con el mensaje personalizado
        if (preg_match("/^[a-zA-Z0-9\s\,\.\¿\?\¡\!\_\-]{1,500}$/", $this->cleanData($this->valor))){
            return true;
        }else {
            $this->error = "No modifiques el boton del submit";
            return false;
        }
    }

    function pintar() {
        echo "<input type='submit' name='$this->name' value='$this->valorSubmit' class='".implode(" ", $this->claseInput)."'>";   
        $this->imprimirError();
    }
}
?>
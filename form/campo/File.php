<?php

namespace form\campo;

class File extends Atipo {

    private $imgWrapper = array();
    private $claseImg = array();
    private $fileWrapper = array();
    private $imgDefault;
    private $accept;
    private $size;
    private $ruta;

    //img default
    public const IMG_DEFAULT = "upload/perfiles/default.png";

    //tipos de archivos aceptados
    public const ACCEPT_BOTH = "image/png,image/jpeg";
    public const ACCEPT_PNG = "image/png";
    public const ACCEPT_JPG = "image/jpg";

    //tamaños de archivos (en bytes)
    public const SIZE_LOW = 500000; //0.5MB
    public const SIZE_DEFAULT = 2000000; //2MB

    //ruta de guardado
    public const RUTA_PERFIL = "upload/perfiles/";

    public function __construct(
        $null,
        $valor,
        $name,
        $label,
        $claseWrapper,
        $claseInput,
        $imgWrapper = [],
        $claseImg = [],
        $fileWrapper = [],
        $imgDefault = self::IMG_DEFAULT,
        $accept = self::ACCEPT_BOTH,
        $size = self::SIZE_DEFAULT,
        $ruta = self::RUTA_PERFIL) 
        {
        parent::__construct($null,$valor,$name,$label,$claseWrapper,$claseInput);
        $this->imgWrapper = $imgWrapper;
        $this->claseImg = $claseImg;
        $this->fileWrapper = $fileWrapper;
        $this->imgDefault = $imgDefault;
        $this->accept = $accept;
        $this->size = $size;
        $this->ruta = $ruta;
    }

    public function getRuta() { return $this->ruta; }

    function validarEspecifico () {
        if (
            ($_FILES[$this->name]["type"] == (self::ACCEPT_PNG || self::ACCEPT_JPG))
            &&
            ($_FILES[$this->name]["size"] <= $this->size)
            &&
            ($_FILES[$this->name]['error'] == 0)
            ) {
            return true;
        }else{
            $this->error="Formato no admitido (no es $this->accept) o tamaño excedido (".$this->size / 1000000 ."MB)";
            return false;
        } 
    }

    function pintar() {
        echo "<div class='".implode(" ", $this->imgWrapper)."'>";
            echo "<img id='image' src='$this->imgDefault' alt='img' class='".implode(" ", $this->claseImg)."'>";
        echo "</div>";
        echo "<div class='".implode(" ", $this->fileWrapper)."'>";
            echo "<label for='$this->name'>Imagen: &nbsp;</label>";
            echo "<input type='file' accept='$this->accept' name='$this->name' id='$this->name' value='hola'>";
        echo "</div>";
        
        echo "<script>";
            echo "
                const image = document.querySelector('#image');
                input = document.querySelector('#$this->name');

                input.addEventListener('change', () => {
                    image.src = URL.createObjectURL(input.files[0]);
                });
            ";
        echo "</script>";
        $this->imprimirError();
    }
}

?>
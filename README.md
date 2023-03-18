# proyectoFormularioDWES_V2
## ¿Qué es?
Es una librería para la validación de formularios en PHP.
## ¿Qué se necesita?
### PHP
```
sudo apt install php-cli
sudo apt install php-mbstring
```
<hr>

## Quick START
Estructura:
```
proyectoFormularioDWES_V2/
    form/
        campo/
            Atipo.php
            Fecha.php
            Multiple.php
            Numero.php
            Texto.php
        claseMain/
            Formulario.php
    public/
        index.php
    src/
        init.php
```
<br>

Empezaremos por meter el autoload en el <b>init.php</b>. Esto nos permitirá la carga automática de las clases según el uso que le demos en cada página:
```php
//autoload
spl_autoload_register(function ($class) {
    // Prefijo del namespace de tu proyecto
    $prefix = 'form\\';

    // Directorio base para el prefijo del namespace
    $base_dir = __DIR__ . '/../form/';

    // Verificar si la clase utiliza el prefijo del namespace
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // No, sigue con el siguiente autoloader registrado
        return;
    }

    // Obtenemos el nombre de la clase sin el prefijo del namespace
    $relative_class = substr($class, $len);

    // Reemplaza los separadores de namespace por separadores de directorios en el nombre de la clase,
    // y añade el directorio base y la extensión .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Si el archivo existe, lo requerimos
    if (file_exists($file)) {
        require $file;
    }
});
```
<br>

Seguidamente requerimos en <b>index.php</b> el init. Y ponemos todos los namespaces de todos los campos que vayamos a usar:
```php
require("../src/init.php");
use form\campo\Atipo;
use form\campo\Fecha;
use form\campo\Multiple;
use form\campo\Numero;
use form\campo\Texto;
use form\claseMain\Formulario;
```
<br>

Una vez hecho esto y siguiendo en <b>index.php</b>. Podremos instanciar un nuevo formulario, con TODOS los campos que queramos:
```php
// ================================= INICIALIZACIÓN DEL FORM =================================
//                             ACTION            METHOD           clases-css-form  CAMPOS
$formulario = new Formulario("index.php", Formulario::METHOD_POST, ["formulario"], array(
    //                                  ================================ COMÚN ================================ // ======================== ESPECÍFICO ========================
    //      (null por defecto) valor    name            label      clases-css-wrapper  clases-css-input      tipoCampo       placeholder         regex
    $nombre = new Texto        (null, "nombre",       "Nombre",    ["input-wrapper"],  ["input"],         Texto::TYPE_TEXT, "Tu nombre...",  Texto::DEFAULT_PATTERN_25),
    $pass = new Texto          (null, "contraseña",   "Password",  ["input-wrapper"],  ["input"],         Texto::TYPE_PSWD, "Tu contra...",  Texto::DEFAULT_PATTERN_25),
    $descripcion = new Texto   (null, "descripcion",  "Descrip",   ["input-wrapper"],  ["input"],         Texto::TYPE_TAREA,"La desc...",    Texto::DEFAULT_PATTERN_500),
    //                                                                                                        tipoCampo            min                     max
    $valoracion = new Numero   (null, "valoracion", "Valoracion",  ["input-wrapper"],  ["input"],         Numero::TYPE_RANGE, Numero::MIN_DEFAULT_0, Numero::MAX_10),
    $vecesVista = new Numero   (null, "vistas",   "¿Veces vista?", ["input-wrapper"],  ["input"],         Numero::TYPE_NUMBER, Numero::MIN_DEFAULT_0, Numero::MAX_10),
    //                                                                                                  clase-wrapper(chboxes)     tipoCampo                     array (checkboxes, radios, selects)                                               
    $generos = new Multiple    (null, "generos",     "¿Géneros?",  ["input-wrapper"],  [""],              ["input-multiple"], Multiple::TYPE_CHECKBOX, ["Comedia", "Terror", "Misterio", "Suspense", "Acción", "Otros"]),
    $emision = new Multiple    (null, "emision",   "¿En emisión?", ["input-wrapper"],  [""],              ["input-multiple"], Multiple::TYPE_RADIO,    ["Sí", "No"]),
    $plataforma = new Multiple (null, "plataforma","¿Plataforma?", ["input-wrapper"],  [""],              ["input-multiple"], Multiple::TYPE_SELECT,   ["Netflix","HBO","Piratilla","Otros"]),
    //                                                                                                                f_ini             f_fin
    $fecha = new Fecha         (null, "fecha",        "Fecha",     ["input-wrapper"],  ["input"],         Fecha::NOW, Fecha::PLUS_ONE_WEEK)
// === SUBMIT ===
// claseWrappSubmit  idSubmit  nameSubm  txtSubmit  clseSubmit
), ["input-wrapper"], "enviar", "enviar", "ENVIAR", ["input"]);
```
La estructura generada del formulario será la siguiente (obviamente aplicándole clases y valores personalizados):
```html
<form>
    <div>
        <label></label>
        <input></input>
    </div>
    .
    .
    <div>
        <input type='submit'></input>
    </div>
</form>
```
<br>

Bien, ya tenemos instanciado nuestro formulario. Y tenemos 3 acciones principales:
1. <b>Pintar todo el formulario</b> (lo cual meteremos dentro del HTML/template). Esta función nos pinta el formulario con todos los campos y conserva los datos en caso de error y vacía los campos si se ha submiteado y se han validado todos los inputs:
    ```php
    //pintar global lleva implicito los errores personalizados
    <?php $formulario->pintarGlobal(); ?>
    ```
2. <b>Validar todos los campos</b>, esta función devuelve un booleano, true si todos han sido validados o false en caso contrario, que se podrá usar como condicional en un if. <b>IMP: usarlo por encima de pintarGlobal(), es decir, ponerlo antes en el código</b>:
    ```php
    <?php
        //si el form ha sido validado
        if ($formulario->validarGlobal()){
            //hace algo
        }
        $formulario->pintarGlobal();
    ?>
    ```

Una vez validados todos los campos del formulario, podremos hacer x acciones, evitando así posibles inyecciones SQL y/o ataques XSS.
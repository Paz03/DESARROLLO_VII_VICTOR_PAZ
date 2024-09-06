
<?php
// Ejemplo básico de strtoupper()
$textoMixto = "HoLa MuNdO";
$textoMayusculas = strtoupper($textoMixto);
echo "Texto original: $textoMixto</br>";
echo "Texto en mayúsculas: $textoMayusculas</br>";

// Ejemplo con una frase
$frase = "php es un lenguaje de programación";
$fraseMayusculas = strtoupper($frase);
echo "</br>Frase original: $frase</br>";
echo "Frase en mayúsculas: $fraseMayusculas</br>";

// Ejercicio: Convierte el nombre de tu ciudad y país a mayúsculas
$ciudad = "Panama";
$pais = "Panama";
$ciudadMayusculas = strtoupper($ciudad);
$paisMayusculas = strtoupper($pais);
echo "</br>Tu ciudad en mayúsculas: $ciudadMayusculas</br>";
echo "Tu país en mayúsculas: $paisMayusculas</br>";

// Bonus: Crear un encabezado para un documento
function crearEncabezado($texto) {
    return str_pad(strtoupper($texto), strlen($texto) + 4, "*", STR_PAD_BOTH);
}

$tituloDocumento = "pagina principal";
echo "</br>" . crearEncabezado($tituloDocumento) . "</br>";

// Extra: Convertir un array de strings a mayúsculas
$pais = ["Argentina", "Panama", "Costa rica", "Jamaica"];
$paisMayusculas = array_map('strtoupper', $pais);
echo "</br>pais originales:</br>";
print_r($pais);
echo "pais en mayúsculas:</br>";
print_r($paisMayusculas);

// Desafío: Crea una función que convierta a mayúsculas solo la primera letra de cada palabra
function primerLetraMayuscula($frase) {
    $palabras = explode(" ", strtolower($frase));
    $palabrasModificadas = array_map(function($palabra) {
        return strtoupper(substr($palabra, 0, 1)) . substr($palabra, 1);
    }, $palabras);
    return implode(" ", $palabrasModificadas);
}

$fraseOriginal = "hola mundo";
$fraseModificada = primerLetraMayuscula($fraseOriginal);
echo "</br>Frase original: $fraseOriginal</br>";
echo "Frase modificada: $fraseModificada</br>";
?>
      

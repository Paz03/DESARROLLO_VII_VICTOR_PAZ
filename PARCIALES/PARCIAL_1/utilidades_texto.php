<?php
    function contar_palabra($texto){
        
        return strlen($texto);
    }
function contar_vocales($texto){
    $patron = ["^/[aeiou]"];
    preg_match_all($patron, $texto, $coincidencias);
    return $coincidencias[1];
}

function invertir_palabra($texto){
}

?>


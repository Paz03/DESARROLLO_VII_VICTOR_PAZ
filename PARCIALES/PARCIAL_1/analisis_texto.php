<?php
    include "utilidades_texto.php";
    $frases=["hola","mundo","texto"];

    echo "contar palabra<br>";
    for ($i=0;$i<3;$i++){
        
        echo "frase: " .$frases[$i]. "= ".contar_palabra($frases[$i]);
        echo "<br>";
    }
    echo "contar vocales <br>";
    for ($i=0;$i<3;$i++){
        echo "frase: " .$frases[$i]. "= ".contar_vocales($frases[$i]);
        echo "<br>";
    }

 
?>
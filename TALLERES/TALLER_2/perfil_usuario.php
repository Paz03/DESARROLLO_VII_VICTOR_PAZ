<?php
    $nombre = "Victor Paz";
    $edad = 20;
    $correo = "pazjunior0303@gmail.com";
    $telefono ="6412-1451";

    const OCUPACION ="Estudiante";

    // Definir los mensajes
    $mensaje1 = "Hola, mi nombre es " . $nombre . " y tengo " . $edad . " años.";
    $mensaje2 = "mi correo es ". $correo ." y  mi telefono es ".$telefono. " soy " . OCUPACION . ".";

    // Mostrar los mensajes usando echo, print y printf
    echo $mensaje1 . "<br>";
    print($mensaje2 . "<br>");

    printf("En resumen: %s, %d años, %s, %s , %s<br>", $nombre, $edad, $correo,$telefono ,OCUPACION);


    echo "<br>Información de debugging:<br>";

    var_dump($nombre);
    echo "<br>";
    var_dump($edad);
    echo "<br>";
    var_dump($correo);
    echo "<br>";
    var_dump($telefono);
    echo "<br>";
    var_dump(OCUPACION);
?>


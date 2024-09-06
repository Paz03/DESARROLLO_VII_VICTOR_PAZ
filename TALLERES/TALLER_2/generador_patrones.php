<?php
// 1. Patrón de triángulo rectángulo con asteriscos
echo "Patrón de triángulo rectángulo:<br>";
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*" ;
    }
    echo "<br>";
}

echo "\n"; // Línea en blanco para separar secciones

// 2. Secuencia de números impares del 1 al 20
echo "Números impares del 1 al 20:\n";
$num = 1;
while ($num <= 20) {
    if ($num % 2 != 0) { // Comprobar si el número es impar
        echo $num . "<br>";
    }
    $num++;
}

echo "<br>"; // Línea en blanco para separar secciones

// 3. Contador regresivo desde 10 hasta 1, saltando el número 5
echo "Contador regresivo de 10 a 1, saltando el 5:\n";
$contador = 10;
do {
    if ($contador == 5) {
        $contador--; // Saltar el número 5
        continue;
    }
    echo $contador . "<br>";
    $contador--;
} while ($contador >= 1);
?>

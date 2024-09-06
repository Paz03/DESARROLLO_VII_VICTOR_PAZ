
<?php
// Ejemplo de uso de explode()
$frase = "Manzana,Naranja,Plátano,Uva";
$frutas = explode(",", $frase);

echo "Frase original: $frase</br>";
echo "Array de frutas:</br>";
print_r($frutas);

// Ejercicio: Crea una variable con una lista de tus 5 películas favoritas separadas por guiones (-)
// y usa explode() para convertirla en un array
$misPeliculas = [
    "Rápido y Furioso",
    "Rápido y Furioso 2",
    "Rápido y Furioso: Reto Tokio",
    "El Conjuro",
    "Expediente Warren: El Caso Enfield"
];
$cadenaPeliculas = implode("-", $misPeliculas);

echo "</br>Mis películas favoritas:</br>";
print_r($cadenaPeliculas);

// Bonus: Usa explode() con un límite
$texto = "Uno,Dos,Tres,Cuatro,Cinco";
$array = explode(",", $texto, 4);

echo "</br>Texto original: $texto</br>";
echo "Array con límite:</br>";
print_r($array);
?>
      

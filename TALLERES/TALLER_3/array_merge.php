
<?php
// Ejemplo básico de array_merge()
$frutas1 = ["manzana", "pera"];
$frutas2 = ["naranja", "uva"];
$todasLasFrutas = array_merge($frutas1, $frutas2);
echo "Todas las frutas:</br>";
print_r($todasLasFrutas);

// Ejemplo con arrays asociativos
$infoPersona1 = ["nombre" => "Juan", "edad" => 30];
$infoPersona2 = ["ciudad" => "Madrid", "profesion" => "Ingeniero"];
$infoCompleta = array_merge($infoPersona1, $infoPersona2);
echo "</br>Información completa de la persona:</br>";
print_r($infoCompleta);

// Ejercicio: Crea dos arrays, uno con tus comidas favoritas y otro con las de un amigo
// Usa array_merge() para combinarlos en un solo array de comidas favoritas
$misComidas = ["Sushi", "Tacos", "Ensalada"]; // Reemplaza con tus comidas favoritas
$comidasAmigo = ["Sopa", "Pizza", "Panqueques"]; // Reemplaza con las comidas favoritas de tu amigo
$todasLasComidas = array_merge($misComidas, $comidasAmigo);
echo "</br>Todas las comidas favoritas:</br>";
print_r($todasLasComidas);

// Bonus: Manejo de claves duplicadas
$array1 = ["x" => "morado", "y" => "naranja"];
$array2 = ["y" => "rojo", "z" => "azul"];
$resultadoMerge = array_merge($array1, $array2);
echo "</br>Resultado de merge con claves duplicadas:</br>";
print_r($resultadoMerge);

// Extra: Uso de array_merge() con múltiples arrays
$numeros1 = [10, 20, 30];
$numeros2 = [40, 50, 60];
$numeros3 = [70, 80, 90];
$todosLosNumeros = array_merge($numeros1, $numeros2, $numeros3);
echo "</br>Todos los números combinados:</br>";
print_r($todosLosNumeros);

// Desafío: Usa array_merge() junto con array_unique() para combinar arrays y eliminar duplicados
$colores1 = ["blanco", "negro", "gris"];
$colores2 = ["gris", "morado", "blanco"];
$coloresUnicos = array_unique(array_merge($colores1, $colores2));
echo "</br>Colores únicos después de combinar:</br>";
print_r($coloresUnicos);
?>


      

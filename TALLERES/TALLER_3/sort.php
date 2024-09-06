
<?php
// Ejemplo básico de sort()
$numeros = [5, 2, 8, 1, 9];
echo "Array original: " . implode(", ", $numeros) . "</br>";
sort($numeros);
echo "Array ordenado: " . implode(", ", $numeros) . "</br>";

// Ordenar strings
$frutas = ["naranja", "manzana", "plátano", "uva"];
echo "</br>Frutas originales: " . implode(", ", $frutas) . "</br>";
sort($frutas);
echo "Frutas ordenadas: " . implode(", ", $frutas) . "</br>";

// Ejercicio: Ordenar calificaciones de estudiantes
$calificaciones = [
    "Laura" => 90,
    "Pedro" => 40,
    "Sofia" => 95,
    "Luis" => 75
];
echo "</br>Calificaciones originales:</br>";
print_r($calificaciones);

asort($calificaciones);  // Ordena por valor manteniendo la asociación de índices
echo "Calificaciones ordenadas por nota:</br>";
print_r($calificaciones);

ksort($calificaciones);  // Ordena por clave (nombre del estudiante)
echo "Calificaciones ordenadas por nombre:</br>";
print_r($calificaciones);

// Bonus: Ordenar en orden descendente
$numeros = [7, 3, 6, 2, 8];
rsort($numeros);
echo "</br>Números en orden descendente: " . implode(", ", $numeros) . "</br>";

// Extra: Ordenar array multidimensional
$estudiantes = [
    ["nombre" => "Laura", "edad" => 23, "promedio" => 8.2],
    ["nombre" => "Pedro", "edad" => 24, "promedio" => 7.5],
    ["nombre" => "Sofia", "edad" => 22, "promedio" => 9.0],
    ["nombre" => "Luis", "edad" => 25, "promedio" => 8.7]
];

// Ordenar por promedio
usort($estudiantes, function($a, $b) {
    return $b['promedio'] <=> $a['promedio'];
});

echo "</br>Estudiantes ordenados por promedio (descendente):</br>";
foreach ($estudiantes as $estudiante) {
    echo "{$estudiante['nombre']}: {$estudiante['promedio']}</br>";
}

// Desafío: Implementar ordenamiento personalizado
function ordenarPorLongitud($a, $b) {
    return strlen($a) - strlen($b);
}

$palabras = ["Java", "C#", "Swift", "Go", "Rust"];
usort($palabras, 'ordenarPorLongitud');
echo "</br>Palabras ordenadas por longitud (ascendente):</br>";
print_r($palabras);

// Ejemplo adicional: Ordenar preservando claves
$datos = [
    "x" => "Primero",
    "y" => "Último",
    "w" => "Medio"
];

ksort($datos);  // Ordena por clave
echo "</br>Datos ordenados por clave:</br>";
print_r($datos);

arsort($datos);  // Ordena por valor en orden descendente
echo "Datos ordenados por valor (descendente):</br>";
print_r($datos);
?>
      

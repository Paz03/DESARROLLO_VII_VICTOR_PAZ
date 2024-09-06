
<?php
// Ejemplo básico de array_filter()
$numeros = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$pares = array_filter($numeros, function($n) {
    return $n % 2 == 0;
});

echo "Números originales: " . implode(", ", $numeros) . "</br>";
echo "Números pares: " . implode(", ", $pares) . "</br>";

// Ejemplo con una función nombrada
function esPrimo($n) {
    if ($n < 2) return false;
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return false;
    }
    return true;
}

$primos = array_filter($numeros, 'esPrimo');
echo "Números primos: " . implode(", ", $primos) . "</br>";


// Ejercicio: Filtra un array de strings para obtener solo las palabras que comienzan con una vocal
$palabras = ["elefante", "avión", "iceberg", "ola", "manzana", "uva", "ratón"];
$empiezaConVocal = array_filter($palabras, function($palabra) {
    return in_array(strtolower($palabra[0]), ['a', 'e', 'i', 'o', 'u']);
});

echo "</br>Palabras originales: " . implode(", ", $palabras) . "</br>";
echo "Palabras que empiezan con vocal: " . implode(", ", $empiezaConVocal) . "</br>";

// Bonus: Filtrar un array asociativo
$personas = [
    ["nombre" => "Laura", "edad" => 28],
    ["nombre" => "Carlos", "edad" => 32],
    ["nombre" => "Beatriz", "edad" => 24],
    ["nombre" => "David", "edad" => 40]
];

$mayoresDe25 = array_filter($personas, function($persona) {
    return $persona['edad'] > 25;
});

echo "</br>Personas mayores de 25 años:</br>";
foreach ($mayoresDe25 as $persona) {
    echo "- {$persona['nombre']} ({$persona['edad']} años)</br>";
}

// Extra: Uso de array_filter() con ARRAY_FILTER_USE_BOTH
$frutas = ["manzana" => 4, "banana" => 6, "naranja" => 3];
$frutasConMasDe3 = array_filter($frutas, function($cantidad, $nombre) {
    return $cantidad > 3 && strlen($nombre) > 6;
}, ARRAY_FILTER_USE_BOTH);

echo "</br>Frutas con más de 3 unidades y nombre largo:</br>";
print_r($frutasConMasDe3);

// Desafío: Crear una función de filtrado personalizada
function filtrarPor($array, $campo, $valor) {
    return array_filter($array, function($item) use ($campo, $valor) {
        return isset($item[$campo]) && $item[$campo] == $valor;
    });
}

$estudiantes = [
    ["nombre" => "Elena", "curso" => "PHP", "nota" => 85],
    ["nombre" => "Miguel", "curso" => "JavaScript", "nota" => 90],
    ["nombre" => "Sofía", "curso" => "PHP", "nota" => 78],
    ["nombre" => "Lucas", "curso" => "Python", "nota" => 92]
];

$estudiantesPHP = filtrarPor($estudiantes, "curso", "PHP");
echo "</br>Estudiantes de PHP:</br>";
foreach ($estudiantesPHP as $estudiante) {
    echo "- {$estudiante['nombre']} (Nota: {$estudiante['nota']})</br>";
}
?>

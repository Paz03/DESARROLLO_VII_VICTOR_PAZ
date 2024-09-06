
<?php
// Ejemplo básico de array_map()
$numeros = [1, 2, 3, 4, 5];
$cuadrados = array_map(function($n) {
    return $n * $n;
}, $numeros);

echo "Números originales: " . implode(", ", $numeros) . "</br>";
echo "Cuadrados: " . implode(", ", $cuadrados) . "</br>";

// Ejemplo con una función nombrada
function duplicar($n) {
    return $n * 2;
}

$duplicados = array_map('duplicar', $numeros);
echo "Números duplicados: " . implode(", ", $duplicados) . "</br>";

// Ejercicio: Convierte un array de strings a mayúsculas
$frutas = ["uva", "plátano", "manzana", "kiwi"];
$frutasMayusculas = array_map('strtoupper', $frutas);

echo "</br>Frutas originales: " . implode(", ", $frutas) . "</br>";
echo "Frutas en mayúsculas: " . implode(", ", $frutasMayusculas) . "</br>";

// Bonus: Usar array_map() con múltiples arrays
$nombres = ["Juan", "Pedro", "María"];
$apellidos = ["Pérez", "Gómez", "López"];
$nombresCompletos = array_map(function($nombre, $apellido) {
    return $nombre . " " . $apellido;
}, $nombres, $apellidos);

echo "</br>Nombres completos:</br>";
foreach ($nombresCompletos as $nombreCompleto) {
    echo "- $nombreCompleto</br>";
}

// Extra: Transformar un array asociativo
$productos = [
    ["nombre" => "Ordenador", "precio" => 1200],
    ["nombre" => "Teléfono", "precio" => 650],
    ["nombre" => "Monitor", "precio" => 300]
];

$productosConDescuento = array_map(function($producto) {
    $producto['precio_descuento'] = $producto['precio'] * 0.85; // 15% de descuento
    return $producto;
}, $productos);

echo "</br>Productos con descuento:</br>";
foreach ($productosConDescuento as $producto) {
    echo "- {$producto['nombre']}: Precio original: {$producto['precio']}, ";
    echo "Precio con descuento: {$producto['precio_descuento']}</br>";
}

// Desafío: Crear una función que aplique diferentes operaciones a cada elemento
function aplicarOperaciones($array, $operaciones) {
    return array_map(function($valor, $operacion) {
        return $operacion($valor);
    }, $array, $operaciones);
}

$valores = [2, 4, 6, 8, 10];
$operaciones = [
    function($n) { return $n * 3; },
    function($n) { return $n - 1; },
    function($n) { return $n / 2; },
    function($n) { return $n ** 2; },
    function($n) { return $n + 5; }
];

$resultados = aplicarOperaciones($valores, $operaciones);

echo "</br>Resultados de operaciones personalizadas:</br>";
foreach ($valores as $index => $valor) {
    echo "Valor original: $valor, Resultado: {$resultados[$index]}</br>";
}
?>

      

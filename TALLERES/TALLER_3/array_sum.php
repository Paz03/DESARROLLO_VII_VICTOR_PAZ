
<?php
// Ejemplo básico de array_sum()
$numeros = [1, 2, 3, 4, 5];
$suma = array_sum($numeros);
echo "La suma de " . implode(", ", $numeros) . " es: $suma</br>";

// Suma de números decimales
$decimales = [1.5, 2.3, 3.7, 4.1, 5.8];
$sumaDecimales = array_sum($decimales);
echo "</br>La suma de los decimales es: " . round($sumaDecimales, 2) . "</br>";

// Ejercicio: Calcular el total de ventas
$ventas = [
    "Lunes" => 100.50,
    "Martes" => 200.75,
    "Miércoles" => 50.25,
    "Jueves" => 300.00,
    "Viernes" => 250.50
];
$totalVentas = array_sum($ventas);
echo "</br>Total de ventas de la semana: $" . number_format($totalVentas, 2) . "</br>";

// Bonus: Calcular el promedio de calificaciones
$calificaciones = [90, 85, 88, 92, 87]; // Reemplaza con tus calificaciones
$promedio = array_sum($calificaciones) / count($calificaciones);
echo "</br>Calificaciones: " . implode(", ", $calificaciones);
echo "</br>Promedio de calificaciones: " . round($promedio, 2) . "</br>";

// Extra: Suma de valores en un array multidimensional
$gastosMensuales = [
    "Abril" => ["Comida" => 320, "Transporte" => 110, "Entretenimiento" => 180],
    "Mayo" => ["Comida" => 290, "Transporte" => 95, "Entretenimiento" => 160],
    "Junio" => ["Comida" => 310, "Transporte" => 120, "Entretenimiento" => 140]
];

$totalGastos = array_sum(array_map('array_sum', $gastosMensuales));
echo "</br>Total de gastos en el trimestre: $" . number_format($totalGastos, 2) . "</br>";

// Desafío: Función para sumar solo valores pares
function sumaPares($array) {
    return array_sum(array_filter($array, function($num) {
        return $num % 2 == 0;
    }));
}

$numeros = [2, 5, 8, 13, 21, 34]; // Reemplaza con tus números
echo "</br>Números: " . implode(", ", $numeros);
echo "</br>Suma de números pares: " . sumaPares($numeros) . "</br>";

// Ejemplo adicional: Cálculo de impuestos
$productos = [
    ["nombre" => "Monitor", "precio" => 300, "impuesto" => 0.18],
    ["nombre" => "Teclado", "precio" => 50, "impuesto" => 0.12],
    ["nombre" => "Ratón", "precio" => 25, "impuesto" => 0.10]
];

$totalImpuestos = array_sum(array_map(function($producto) {
    return $producto['precio'] * $producto['impuesto'];
}, $productos));

echo "</br>Total de impuestos a pagar: $" . number_format($totalImpuestos, 2) . "</br>";
?>
      

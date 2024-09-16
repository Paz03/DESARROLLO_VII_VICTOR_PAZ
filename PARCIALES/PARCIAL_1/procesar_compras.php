<?php

include "funciones_tienda.php";
$productos = [
    ["nombre" => "camisa", "precio" => 50],
    ["nombre" => "panatalon", "precio" => 70],
    ["nombre" => "zapatos", "precio" => 80],
    ["nombre" => "calcetines", "precio" => 10],
    ["nombre" => "gorra", "precio" => 25]
];

$carrito = [
    ["nombre" => "camisa", "cantidad" => 2],
    ["nombre" => "panatalon", "cantidad" => 2],
    ["nombre" => "zapatos", "cantidad" => 1],
    ["nombre" => "calcetines", "cantidad" => 1],
    ["nombre" => "gorra", "cantidad" => 0]
];



$subtotal = array_sum(array_map(function($productos,$carrito) {
    return $productos['precio'] * $carrito['cantidad'];
}, $productos));

echo "Lista de productos<br>";
foreach ($productos as $producto) {
    echo "Nombre: " . $producto["nombre"] . "<br>";
    echo "Precio:".$producto["precio"] . "<br>";
    echo "cantidad:".$carrito["precio"] . "<br>";
    }
    echo "<br><br>";

    $descuento=calcular_descuento($subtotal);
    $impuesto=aplicar_impuesto($subtotal);
    $total=calcular_total($subtotal,$descuento,$impuesto);

    echo "subtotal = ".$subtotal. "<br>";
    echo "descuento = ".$descuento. "<br>";
    echo "impuesto = ".$impuesto. "<br>";
    echo "total = ".$total. "<br>";




?>
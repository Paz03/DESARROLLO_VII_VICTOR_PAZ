<?php
function leer_inventario($archivo) {
    $contenido = file_get_contents($archivo);
    return json_decode($contenido, true);
}

function ordenar_inventario(&$inventario) {
    usort($inventario, function($a, $b) {
        return strcmp($a['nombre'], $b['nombre']);
    });
}

function mostrar_resumen($inventario) {
    ordenar_inventario($inventario);
    foreach ($inventario as $producto) {
        echo "Nombre: " . $producto['nombre'] . ", Precio: " . $producto['precio'] . ", Cantidad: " . $producto['cantidad'] . "<br>";
    }
}

function calcular_valor_total($inventario) {
    return array_sum(array_map(function($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $inventario));
}

function informe_stock_bajo($inventario) {
    $stock_bajo = array_filter($inventario, function($producto) {
        return $producto['cantidad'] < 5;
    });

    if (empty($stock_bajo)) {
        echo "No hay productos con stock bajo.\n";
    } else {
        echo "Productos con stock bajo:\n";
        foreach ($stock_bajo as $producto) {
            echo "Nombre: " . $producto['nombre'] . ", Cantidad: " . $producto['cantidad'] . "\n";
        }
    }
}

$archivo = 'inventario.json';
$inventario = leer_inventario($archivo);
echo "Resumen del inventario:<br>";
mostrar_resumen($inventario);
$valor_total = calcular_valor_total($inventario);
echo "\nValor total del inventario: $" . $valor_total . "<br>";
echo "<br>";
informe_stock_bajo($inventario);

?>

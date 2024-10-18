<?php
include 'config_sesion.php';

// Lista de productos
$productos = [
    1 => ['nombre' => 'Producto 1', 'precio' => 10.00],
    2 => ['nombre' => 'Producto 2', 'precio' => 20.00],
    3 => ['nombre' => 'Producto 3', 'precio' => 15.00],
    4 => ['nombre' => 'Producto 4', 'precio' => 25.00],
    5 => ['nombre' => 'Producto 5', 'precio' => 30.00],
];

// Calcular total
$total = 0;
$compras = [];

// Recopilar información de compras
if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $id => $cantidad) {
        $compras[] = [
            'nombre' => htmlspecialchars($productos[$id]['nombre']),
            'precio' => htmlspecialchars($productos[$id]['precio']),
            'cantidad' => htmlspecialchars($cantidad)
        ];
        $total += $productos[$id]['precio'] * $cantidad;
    }
    
    // Vaciar el carrito
    unset($_SESSION['carrito']);

    // Configurar cookie para recordar el usuario
    setcookie('nombre_usuario', 'Usuario', time() + 86400); // 24 horas
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>
<body>
    <h1>Resumen de Compra</h1>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
        </tr>
        <?php foreach ($compras as $compra): ?>
        <tr>
            <td><?php echo $compra['nombre']; ?></td>
            <td><?php echo $compra['precio']; ?> €</td>
            <td><?php echo $compra['cantidad']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h2>Total: <?php echo htmlspecialchars($total); ?> €</h2>
    <p>Gracias por su compra!</p>
    <a href="productos.php">Volver a Productos</a>
</body>
</html>

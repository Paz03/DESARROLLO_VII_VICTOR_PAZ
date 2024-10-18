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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Carrito</title>
</head>
<body>
    <h1>Tu Carrito</h1>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Acción</th>
        </tr>
        <?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
            <?php foreach ($_SESSION['carrito'] as $id => $cantidad): ?>
                <tr>
                    <td><?php echo htmlspecialchars($productos[$id]['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($productos[$id]['precio']); ?> €</td>
                    <td><?php echo htmlspecialchars($cantidad); ?></td>
                    <td>
                        <form action="eliminar_del_carrito.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" value="Eliminar">
                        </form>
                    </td>
                </tr>
                <?php $total += $productos[$id]['precio'] * $cantidad; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">El carrito está vacío.</td>
            </tr>
        <?php endif; ?>
    </table>
    <h2>Total: <?php echo htmlspecialchars($total); ?> €</h2>
    <a href="checkout.php">Proceder al Checkout</a>
    <br>
    <a href="productos.php">Volver a Productos</a>
</body>
</html>

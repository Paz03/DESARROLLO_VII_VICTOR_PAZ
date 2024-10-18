<?php
include 'config_sesion.php';

// Lista de productos
$productos = [
    ['id' => 1, 'nombre' => 'Tablet', 'precio' => 100.00],
    ['id' => 2, 'nombre' => 'Laptop', 'precio' => 200.00],
    ['id' => 3, 'nombre' => 'Telefono', 'precio' => 150.00],
    ['id' => 4, 'nombre' => 'Radio', 'precio' => 50.00],
    ['id' => 5, 'nombre' => 'Nevera', 'precio' => 240.00],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>
    <h1>Lista de Productos</h1>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
            <td><?php echo htmlspecialchars($producto['precio']); ?> €</td>
            <td>
                <form action="agregar_al_carrito.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                    <input type="submit" value="Añadir al Carrito">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="ver_carrito.php">Ver Carrito</a>
</body>
</html>

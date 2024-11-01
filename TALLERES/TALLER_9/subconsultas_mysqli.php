<?php
require_once "config_mysqli.php";

// 1. Productos que tienen un precio mayor al promedio de su categoría
$sql = "SELECT p.nombre, p.precio, c.nombre as categoria,
        (SELECT AVG(precio) FROM productos WHERE categoria_id = p.categoria_id) as promedio_categoria
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.precio > (
            SELECT AVG(precio)
            FROM productos p2
            WHERE p2.categoria_id = p.categoria_id
        )";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: {$row['nombre']}, Precio: {$row['precio']}, ";
        echo "Categoría: {$row['categoria']}, Promedio categoría: {$row['promedio_categoria']}<br>";
    }
    mysqli_free_result($result);
}

// 2. Clientes con compras superiores al promedio
$sql = "SELECT c.nombre, c.email,
        (SELECT SUM(total) FROM ventas WHERE cliente_id = c.id) as total_compras,
        (SELECT AVG(total) FROM ventas) as promedio_ventas
        FROM clientes c
        WHERE (
            SELECT SUM(total)
            FROM ventas
            WHERE cliente_id = c.id
        ) > (
            SELECT AVG(total)
            FROM ventas
        )";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Cliente: {$row['nombre']}, Total compras: {$row['total_compras']}, ";
        echo "Promedio general: {$row['promedio_ventas']}<br>";
    }
    mysqli_free_result($result);
}

// 3. Productos que nunca se han vendido
$sql = "SELECT p.nombre FROM productos p 
        LEFT JOIN ventas v ON p.id = v.id
        WHERE v.id IS NULL";

$result = mysqli_query($conn, $sql);

echo "<h3>Productos que nunca se han vendido:</h3>";
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: {$row['nombre']}<br>";
    }
    mysqli_free_result($result);
}

// 4. Categorías con el número de productos y el valor total del inventario
$sql = "SELECT c.nombre AS categoria, COUNT(p.id) AS numero_productos, 
        SUM(p.precio * p.stock) AS valor_inventario 
        FROM categorias c 
        LEFT JOIN productos p ON c.id = p.id 
        GROUP BY c.id";

$result = mysqli_query($conn, $sql);

echo "<h3>Categorías con el número de productos y el valor total del inventario:</h3>";
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Categoría: {$row['categoria']}, Número de productos: {$row['numero_productos']}, Valor total del inventario: {$row['valor_inventario']}<br>";
    }
    mysqli_free_result($result);
}

// 5. Clientes que han comprado todos los productos de una categoría específica
$categoria_id = 1;  
$sql = "SELECT c.nombre FROM clientes c 
        WHERE NOT EXISTS (
            SELECT p.id FROM productos p 
            WHERE p.id = ? 
            AND NOT EXISTS (
                SELECT v.id FROM ventas v 
                WHERE v.cliente_id = c.id AND v.id = p.id
            )
        )";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $categoria_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

echo "<h3>Clientes que han comprado todos los productos de la categoría específica:</h3>";
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Cliente: {$row['nombre']}<br>";
    }
    mysqli_free_result($result);
}

// 6. Porcentaje de ventas de cada producto respecto al total de ventas
$sql = "SELECT p.nombre, 
        (SUM(dv.cantidad) / (SELECT SUM(cantidad) FROM detalles_venta) * 100) AS porcentaje_ventas 
        FROM productos p 
        JOIN detalles_venta dv ON p.id = dv.producto_id 
        GROUP BY p.id";

try {
    $stmt = $pdo->query($sql);

    echo "<h3>Porcentaje de ventas de cada producto respecto al total de ventas:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Producto: {$row['nombre']}, Porcentaje de ventas: {$row['porcentaje_ventas']}%<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;

<?php
require_once "config_pdo.php"; // O usar mysqli según prefieras

function verificarCambiosPrecio($pdo, $producto_id, $nuevo_precio) {
    try {
        
        $stmt = $pdo->prepare("UPDATE productos SET precio = ? WHERE id = ?");
        $stmt->execute([$nuevo_precio, $producto_id]);
        
      
        $stmt = $pdo->prepare("SELECT * FROM historial_precios WHERE producto_id = ? ORDER BY fecha_cambio DESC LIMIT 1");
        $stmt->execute([$producto_id]);
        $log = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Cambio de Precio Registrado:</h3>";
        echo "Precio anterior: $" . $log['precio_anterior'] . "<br>";
        echo "Precio nuevo: $" . $log['precio_nuevo'] . "<br>";
        echo "Fecha del cambio: " . $log['fecha_cambio'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function verificarMovimientoInventario($pdo, $producto_id, $nueva_cantidad) {
    try {
        
        $stmt = $pdo->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        $stmt->execute([$nueva_cantidad, $producto_id]);
        
       
        $stmt = $pdo->prepare("
            SELECT * FROM movimientos_inventario 
            WHERE producto_id = ? 
            ORDER BY fecha_movimiento DESC LIMIT 1
        ");
        $stmt->execute([$producto_id]);
        $movimiento = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Movimiento de Inventario Registrado:</h3>";
        echo "Tipo de movimiento: " . $movimiento['tipo_movimiento'] . "<br>";
        echo "Cantidad: " . $movimiento['cantidad'] . "<br>";
        echo "Stock anterior: " . $movimiento['stock_anterior'] . "<br>";
        echo "Stock nuevo: " . $movimiento['stock_nuevo'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


// Función para actualizar nivel de membresía de un cliente en base a su historial de compras
function actualizarNivelMembresia($pdo, $cliente_id, $monto_compra) {
    try {
        // Insertar una nueva compra en el historial
        $stmt = $pdo->prepare("INSERT INTO historial_compras (cliente_id, monto) VALUES (?, ?)");
        $stmt->execute([$cliente_id, $monto_compra]);

        // Consultar el nivel de membresía actualizado
        $stmt = $pdo->prepare("SELECT nivel_membresia FROM clientes WHERE id = ?");
        $stmt->execute([$cliente_id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<h3>Nivel de Membresía Actualizado:</h3>";
        echo "Cliente ID: " . $cliente_id . "<br>";
        echo "Nuevo Nivel de Membresía: " . $cliente['nivel_membresia'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Función para actualizar la tabla de estadísticas con el total de ventas por categoría
function actualizarEstadisticasVentas($pdo, $categoria_id, $cantidad_venta) {
    try {
        $stmt = $pdo->prepare("INSERT INTO ventas (categoria_id, cantidad) VALUES (?, ?)");
        $stmt->execute([$categoria_id, $cantidad_venta]);

        $stmt = $pdo->prepare("SELECT total_ventas FROM estadisticas_ventas WHERE categoria_id = ?");
        $stmt->execute([$categoria_id]);
        $estadistica = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<h3>Estadísticas de Ventas Actualizadas:</h3>";
        echo "Categoría ID: " . $categoria_id . "<br>";
        echo "Total de Ventas: " . $estadistica['total_ventas'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Función para verificar stock y enviar alertas si el stock es crítico
function verificarStockCritico($pdo, $producto_id, $nueva_cantidad) {
    try {
        $stmt = $pdo->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        $stmt->execute([$nueva_cantidad, $producto_id]);

        
        $stmt = $pdo->prepare("SELECT stock FROM productos WHERE id = ?");
        $stmt->execute([$producto_id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($producto['stock'] < 10) { 
            echo "<h3>Alerta de Stock Crítico:</h3>";
            echo "Producto ID: " . $producto_id . "<br>";
            echo "Stock Actual: " . $producto['stock'] . "<br>";
            echo "Advertencia: El stock de este producto está en un nivel crítico.<br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}




// Probar los triggers
verificarCambiosPrecio($pdo, 1, 999.99);
verificarMovimientoInventario($pdo, 1, 15);
actualizarNivelMembresia($pdo, 1, 200);
actualizarEstadisticasVentas($pdo, 2, 5);
verificarStockCritico($pdo, 1, 8);


$pdo = null;
?>

<?php
require_once "config_pdo.php";

// Función para registrar una venta
function registrarVenta($pdo, $cliente_id, $producto_id, $cantidad) {
    try {
        $stmt = $pdo->prepare("CALL sp_registrar_venta(:cliente_id, :producto_id, :cantidad, @venta_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
        
        // Obtener el ID de la venta
        $result = $pdo->query("SELECT @venta_id as venta_id")->fetch(PDO::FETCH_ASSOC);
        
        echo "Venta registrada con éxito. ID de venta: " . $result['venta_id'];
    } catch (PDOException $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($pdo, $cliente_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_estadisticas_cliente(:cliente_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $estadisticas = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Función para procesar devolución
function procesarDevolucion($pdo, $venta_id, $producto_id, $cantidad) {
    $query = "CALL sp_procesar_devolucion(?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$venta_id, $producto_id, $cantidad]);

    $mensaje = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($mensaje) {
        echo $mensaje['resultado'];
    } else {
        echo "No se pudo procesar la devolución.";
    }
}

// Función para aplicar descuento a un cliente
function aplicarDescuentoCliente($pdo, $cliente_id) {
    $query = "CALL sp_aplicar_descuento_cliente(?, @descuento_aplicado)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$cliente_id]);

    $stmt->closeCursor(); 

    $result = $pdo->query("SELECT @descuento_aplicado AS descuento_aplicado")->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        echo "<br>Descuento aplicado: " . $result['descuento_aplicado'] . "%";
    } else {
        echo "No se pudo aplicar el descuento.";
    }
}

// Función para generar un reporte de bajo stock
function reporteBajoStock($pdo) {
    $query = "CALL sp_reporte_bajo_stock()";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute()) {
        echo "<h3>Reporte de Productos con Stock</h3>";
        echo "<table><tr><th>Producto</th><th>Stock Actual</th></tr>";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>" . $row['producto'] . "</td><td>" . $row['stock_actual'] . "</td></tr>";
        }
        
        echo "</table>";
    } else {
        echo "Error al ejecutar el procedimiento: " . $stmt->errorInfo()[2];
    }
}

// Función para calcular comisiones por ventas
function calcularComisionVentas($pdo, $cliente_id, $periodo_inicio, $periodo_fin) {
    $query = "CALL sp_calcular_comision_ventas(?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$cliente_id, $periodo_inicio, $periodo_fin]);

    $comision = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($comision) {
        echo "Total de comisión calculada: $" . $comision['comision_total'];
    } else {
        echo "No se encontraron comisiones para el periodo especificado.";
    }
}

// Ejemplos de uso
registrarVenta($pdo, 1, 1, 2);
obtenerEstadisticasCliente($pdo, 1);
procesarDevolucion($pdo, 1, 1, 1);
aplicarDescuentoCliente($pdo, 1);
reporteBajoStock($pdo);
calcularComisionVentas($pdo, 1, '2024-01-01', '2024-12-31');
$pdo = null;
?>
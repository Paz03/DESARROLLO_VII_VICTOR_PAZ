<?php
require_once "config_mysqli.php";

// Función para registrar una venta
function registrarVenta($conn, $cliente_id, $producto_id, $cantidad) {
    $query = "CALL sp_registrar_venta(?, ?, ?, @venta_id)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $cliente_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        
        // Obtener el ID de la venta
        $result = mysqli_query($conn, "SELECT @venta_id as venta_id");
        $row = mysqli_fetch_assoc($result);
        
        echo "Venta registrada con éxito. ID de venta: " . $row['venta_id'];
    } catch (Exception $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($conn, $cliente_id) {
    $query = "CALL sp_estadisticas_cliente(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $estadisticas = mysqli_fetch_assoc($result);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    }
    
    mysqli_stmt_close($stmt);
}


function procesarDevolucion($conn, $venta_id, $producto_id, $cantidad) {
    $query = "CALL sp_procesar_devolucion(?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $venta_id, $producto_id, $cantidad);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $mensaje = mysqli_fetch_assoc($result);
        echo $mensaje['resultado'];
    }
    
    mysqli_stmt_close($stmt);
}

function aplicarDescuentoCliente($conn, $cliente_id) {
    $query = "CALL sp_aplicar_descuento_cliente(?, @descuento_aplicado)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);

    if (mysqli_stmt_execute($stmt)) {
        
        mysqli_stmt_close($stmt);
       
        $result = mysqli_query($conn, "SELECT @descuento_aplicado AS descuento_aplicado");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            echo "<br>Descuento aplicado: " . $row['descuento_aplicado'] . "%";
          
            mysqli_free_result($result);
        }
    } 
}

function reporteBajoStock($conn) {
    // Llama al procedimiento sin pasar ningún argumento
    $query = "CALL sp_reporte_bajo_stock()";
    $stmt = mysqli_prepare($conn, $query);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        
        echo "<h3>Reporte de Productos con Stock";
        echo "<table><tr><th>Producto</th><th>Stock Actual</th></tr>";
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row['producto'] . "</td><td>" . $row['stock_actual'] . "</td></tr>";
        }
        
        echo "</table>";
    } else {
        echo "Error al ejecutar el procedimiento: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}


function calcularComisionVentas($conn, $cliente_id, $periodo_inicio, $periodo_fin) {
    $query = "CALL sp_calcular_comision_ventas(?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iss", $cliente_id, $periodo_inicio, $periodo_fin);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $comision = mysqli_fetch_assoc($result);
        echo "Total de comisión calculada: $" . $comision['comision_total'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}



// Ejemplos de uso
registrarVenta($conn, 1, 1, 2);
obtenerEstadisticasCliente($conn, 1);
procesarDevolucion($conn, 1, 1, 1);
aplicarDescuentoCliente($conn, 1);
reporteBajoStock($conn, 5);
calcularComisionVentas($conn, 1, '2024-01-01', '202-12-31');

mysqli_close($conn);
?>
        
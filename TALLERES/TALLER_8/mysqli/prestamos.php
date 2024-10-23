<?php
include 'config_mysqli.php';

// Registrar préstamo
function registrarPrestamo($usuario_id, $libro_id) {
    global $conn;
    $conn->autocommit(FALSE); // Desactivar el autocommit para el manejo de transacciones
    $cantidad_disponible = 0;

    try {
        // Verificar disponibilidad del libro
        $stmt1 = $conn->prepare("SELECT cantidad_disponible FROM libros WHERE id = ?");
        $stmt1->bind_param("i", $libro_id);
        $stmt1->execute();
        $stmt1->bind_result($cantidad_disponible);
        $stmt1->fetch();
        $stmt1->close();

        // Verificar si hay libros disponibles
        if ($cantidad_disponible <= 0) {
            throw new Exception("No hay libros disponibles para prestar.");
        }

        // Actualizar disponibilidad del libro
        $stmt2 = $conn->prepare("UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id = ?");
        $stmt2->bind_param("i", $libro_id);
        $stmt2->execute();
        $stmt2->close();

        // Registrar préstamo
        $stmt3 = $conn->prepare("INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, estado) VALUES (?, ?, NOW(), 'activo')");
        $stmt3->bind_param("ii", $usuario_id, $libro_id);
        $stmt3->execute();
        $stmt3->close();

        $conn->commit(); // Confirmar la transacción
        return true; // Retornar true en caso de éxito
    } catch (Exception $e) {
        $conn->rollback(); // Deshacer cambios si ocurre un error
        return false; // Retornar false en caso de fallo
    }
}

// Listar préstamos activos
function listarPrestamosActivos() {
    global $conn;
    $stmt = $conn->prepare("SELECT prestamos.*, libros.titulo, usuarios.nombre 
                            FROM prestamos
                            JOIN libros ON prestamos.id_libro = libros.id
                            JOIN usuarios ON prestamos.id_usuario = usuarios.id
                            WHERE prestamos.estado = 'activo'");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC); // Devolver todos los resultados como un array asociativo
}

// Registrar devolución de un libro
function registrarDevolucion($prestamo_id) {
    global $conn;
    $conn->autocommit(FALSE); // Desactivar el autocommit para el manejo de transacciones

    try {
        // Actualizar estado del préstamo
        $stmt1 = $conn->prepare("UPDATE prestamos SET estado = 'devuelto', fecha_devolucion = NOW() WHERE id = ?");
        $stmt1->bind_param("i", $prestamo_id);
        $stmt1->execute();
        $stmt1->close();

        // Actualizar disponibilidad del libro
        $stmt2 = $conn->prepare("UPDATE libros SET cantidad_disponible = cantidad_disponible + 1 WHERE id = (SELECT id_libro FROM prestamos WHERE id = ?)");
        $stmt2->bind_param("i", $prestamo_id);
        $stmt2->execute();
        $stmt2->close();

        $conn->commit(); // Confirmar la transacción
        return true; // Retornar true en caso de éxito
    } catch (Exception $e) {
        $conn->rollback(); // Deshacer cambios si ocurre un error
        return false; // Retornar false en caso de fallo
    }
}

// Mostrar historial de préstamos por usuario
function historialPrestamosPorUsuario($usuario_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT prestamos.*, libros.titulo, prestamos.fecha_devolucion 
                             FROM prestamos
                             JOIN libros ON prestamos.id_libro = libros.id
                             WHERE prestamos.id_usuario = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC); // Devolver todos los resultados como un array asociativo
}
?>

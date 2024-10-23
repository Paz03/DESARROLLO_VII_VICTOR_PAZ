<?php
include 'config_pdo.php';

// Registrar préstamo
function registrarPrestamo($usuario_id, $libro_id) {
    global $pdo;
    $pdo->beginTransaction(); // Iniciar transacción

    try {
        // Verificar disponibilidad del libro
        $stmt1 = $pdo->prepare("SELECT cantidad_disponible FROM libros WHERE id = ?");
        $stmt1->execute([$libro_id]);
        $cantidad_disponible = $stmt1->fetchColumn();

        // Verificar si hay libros disponibles
        if ($cantidad_disponible <= 0) {
            throw new Exception("No hay libros disponibles para prestar.");
        }

        // Actualizar disponibilidad del libro
        $stmt2 = $pdo->prepare("UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id = ?");
        $stmt2->execute([$libro_id]);

        // Registrar préstamo
        $stmt3 = $pdo->prepare("INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, estado) VALUES (?, ?, NOW(), 'activo')");
        $stmt3->execute([$usuario_id, $libro_id]);

        $pdo->commit(); // Confirmar la transacción
        return true; // Retornar true en caso de éxito
    } catch (Exception $e) {
        $pdo->rollBack(); // Deshacer cambios si ocurre un error
        return false; // Retornar false en caso de fallo
    }
}

// Listar préstamos activos
function listarPrestamosActivos() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT prestamos.*, libros.titulo, usuarios.nombre 
                            FROM prestamos
                            JOIN libros ON prestamos.id_libro = libros.id
                            JOIN usuarios ON prestamos.id_usuario = usuarios.id
                            WHERE prestamos.estado = 'activo'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devolver todos los resultados como un array asociativo
}

// Registrar devolución de un libro
function registrarDevolucion($prestamo_id) {
    global $pdo;
    $pdo->beginTransaction(); // Iniciar transacción

    try {
        // Actualizar estado del préstamo
        $stmt1 = $pdo->prepare("UPDATE prestamos SET estado = 'devuelto', fecha_devolucion = NOW() WHERE id = ?");
        $stmt1->execute([$prestamo_id]);

        // Actualizar disponibilidad del libro
        $stmt2 = $pdo->prepare("UPDATE libros SET cantidad_disponible = cantidad_disponible + 1 WHERE id = (SELECT id_libro FROM prestamos WHERE id = ?)");
        $stmt2->execute([$prestamo_id]);

        $pdo->commit(); // Confirmar la transacción
        return true; // Retornar true en caso de éxito
    } catch (Exception $e) {
        $pdo->rollBack(); // Deshacer cambios si ocurre un error
        return false; // Retornar false en caso de fallo
    }
}

// Mostrar historial de préstamos por usuario
function historialPrestamosPorUsuario($usuario_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT prestamos.*, libros.titulo, prestamos.fecha_devolucion 
                             FROM prestamos
                             JOIN libros ON prestamos.id_libro = libros.id
                             WHERE prestamos.id_usuario = ?");
    $stmt->execute([$usuario_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devolver todos los resultados como un array asociativo
}
?>
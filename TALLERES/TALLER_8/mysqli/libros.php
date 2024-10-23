<?php
include 'config_mysqli.php';

// Añadir libro
function agregarLibro($titulo, $autor, $isbn, $anio_publicacion, $cantidad_disponible) {
    global $conn;
    
    $sql = "INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad_disponible) 
            VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssii", $titulo, $autor, $isbn, $anio_publicacion, $cantidad_disponible);
        
        if ($stmt->execute()) {
            echo "Libro agregado exitosamente.";
        } else {
            echo "Error al agregar el libro: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la consulta preparada: " . $conn->error;
    }
}

// Listar libros
function listarLibros($pagina = 1, $limite = 10) {
    global $conn;
    $inicio = ($pagina - 1) * $limite;
    $result = $conn->query("SELECT * FROM libros LIMIT $inicio, $limite");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Buscar libro
function buscarLibro($campo, $valor) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM libros WHERE $campo LIKE ?");
    $valor = "%" . $valor . "%";
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Actualizar libro
function actualizarLibro($id, $titulo, $autor, $isbn, $anio, $cantidad) {
    global $conn;
    $stmt = $conn->prepare("UPDATE libros SET titulo = ?, autor = ?, isbn = ?, anio_publicacion = ?, cantidad_disponible = ? WHERE id = ?");
    $stmt->bind_param("sssisi", $titulo, $autor, $isbn, $anio, $cantidad, $id);
    return $stmt->execute();
}

// Eliminar libro
function eliminarLibro($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM libros WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>

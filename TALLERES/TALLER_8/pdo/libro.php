<?php
include 'config_pdo.php';

// Añadir libro
function agregarLibro($titulo, $autor, $isbn, $anio_publicacion, $cantidad_disponible) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad_disponible) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$titulo, $autor, $isbn, $anio_publicacion, $cantidad_disponible]);
}

// Listar libros
function listarLibros($pagina = 1, $limite = 10) {
    global $pdo;
    $inicio = ($pagina - 1) * $limite;
    $stmt = $pdo->prepare("SELECT * FROM libros LIMIT ?, ?");
    $stmt->bindValue(1, $inicio, PDO::PARAM_INT);
    $stmt->bindValue(2, $limite, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Buscar libro
function buscarLibro($campo, $valor) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM libros WHERE $campo LIKE ?");
    $stmt->execute(['%' . $valor . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Actualizar libro
function actualizarLibro($id, $titulo, $autor, $isbn, $anio, $cantidad) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE libros SET titulo = ?, autor = ?, isbn = ?, anio = ?, cantidad = ? WHERE id = ?");
    return $stmt->execute([$titulo, $autor, $isbn, $anio, $cantidad, $id]);
}

// Eliminar libro
function eliminarLibro($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM libros WHERE id = ?");
    return $stmt->execute([$id]);
}
?>

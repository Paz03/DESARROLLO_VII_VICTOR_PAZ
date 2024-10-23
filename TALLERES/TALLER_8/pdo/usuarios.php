<?php
include 'config_pdo.php';

// Registrar usuario
function registrarUsuario($nombre, $email, $contraseña) {
    global $pdo;

    // Validar que los campos no sean vacíos
    if (empty($nombre) || empty($email) || empty($contraseña)) {
        return false; // Devuelve false si hay campos vacíos
    }

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)");
    
    if (!$stmt->execute([$nombre, $email, $contraseña])) {
        // Muestra el error si la ejecución falla
        echo "Error: " . $stmt->errorInfo()[2];
        return false;
    }
    
    return true; // Devuelve true si se inserta correctamente
}

// Listar usuarios
function listarUsuarios($pagina = 1, $limite = 10) {
    global $pdo;
    $inicio = ($pagina - 1) * $limite;
    $stmt = $pdo->prepare("SELECT * FROM usuarios LIMIT ?, ?");
    $stmt->bindValue(1, $inicio, PDO::PARAM_INT);
    $stmt->bindValue(2, $limite, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Buscar usuario por nombre o email
function buscarUsuario($campo, $valor) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE $campo LIKE ?");
    $valor = "%" . $valor . "%";
    $stmt->execute([$valor]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Actualizar usuario
function actualizarUsuario($id, $nombre, $email, $contraseña = null) {
    global $pdo;
    if ($contraseña) {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ?, contraseña = ? WHERE id = ?");
        return $stmt->execute([$nombre, $email, $contraseña, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
        return $stmt->execute([$nombre, $email, $id]);
    }
}

// Eliminar usuario
function eliminarUsuario($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    return $stmt->execute([$id]);
}
?>
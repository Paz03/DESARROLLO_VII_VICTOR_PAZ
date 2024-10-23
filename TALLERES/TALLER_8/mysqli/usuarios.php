<?php
include 'config_mysqli.php';

// Registrar usuario
// Registrar usuario
function registrarUsuario($nombre, $email, $contraseña) {
    global $conn;

    // Validar que los campos no sean vacíos
    if (empty($nombre) || empty($email) || empty($contraseña)) {
        return false; // Devuelve false si hay campos vacíos
    }

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $contraseña);
    
    if (!$stmt->execute()) {
        // Muestra el error si la ejecución falla
        echo "Error: " . $stmt->error;
        return false;
    }
    
    return true; // Devuelve true si se inserta correctamente
}


// Listar usuarios
function listarUsuarios($pagina = 1, $limite = 10) {
    global $conn;
    $inicio = ($pagina - 1) * $limite;
    $result = $conn->query("SELECT * FROM usuarios LIMIT $inicio, $limite");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Buscar usuario por nombre o email
function buscarUsuario($campo, $valor) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE $campo LIKE ?");
    $valor = "%" . $valor . "%";
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Actualizar usuario
function actualizarUsuario($id, $nombre, $email, $contraseña = null) {
    global $conn;
    if ($contraseña) {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nombre, $email, $contraseña, $id);
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nombre, $email, $id);
    }
    return $stmt->execute();
}

// Eliminar usuario
function eliminarUsuario($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>

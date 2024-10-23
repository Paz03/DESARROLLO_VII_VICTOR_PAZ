<?php
include 'config_mysqli.php';  // Conexión a la base de datos
include 'usuarios.php';        // Funciones para manejar usuarios
include 'prestamos.php';       // Funciones para manejar préstamos
include 'libros.php';  

// Manejo de formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_user'])) {
        $nombre = $_POST['nombre'] ?? ''; // Captura el nombre
        $email = $_POST['email'] ?? ''; // Captura el email
        $contraseña = $_POST['contraseña'] ?? ''; // Captura la contraseña
    
        // Llama a la función para registrar el usuario
        if (registrarUsuario($nombre, $email, $contraseña)) {
            echo "Usuario registrado exitosamente.";
        } else {
            echo "Error al registrar el usuario. Asegúrate de que todos los campos están llenos.";
        }
    } elseif (isset($_POST['delete_user'])) {
        // Eliminar usuario
        $id = $_POST['id'];
        eliminarUsuario($id);
    } elseif (isset($_POST['update_user'])) {
        // Actualizar usuario
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'] ?? null; // Cambiado a 'contraseña'
        actualizarUsuario($id, $nombre, $email, $contraseña);
    } elseif (isset($_POST['add_prestamo'])) {
        // Registrar préstamo
        $id_usuario = $_POST['id_usuario'];
        $id_libro = $_POST['id_libro'];
        registrarPrestamo($id_usuario, $id_libro);
    } elseif (isset($_POST['return_prestamo'])) {
        // Devolver préstamo
        $id_usuario = $_POST['id_usuario']; // Cambiado a 'id_usuario'
        $id_libro = $_POST['id_libro'];     // Cambiado a 'id_libro'

        // Comprobar que ambas variables están disponibles
        if ($id_usuario !== null && $id_libro !== null) {
            // Llamar a la función para devolver el préstamo
            if (registrarDevolucion($id_usuario, $id_libro)) {
                echo "Préstamo devuelto exitosamente.";
            } else {
                echo "Error al devolver el préstamo.";
            }
        } else {
            echo "Faltan los datos del usuario o del libro.";
        }
    } elseif (isset($_POST['add'])) {
        // Añadir libro
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $isbn = $_POST['isbn'];
        $anio_publicacion = $_POST['anio_publicacion'];
        $cantidad_disponible = $_POST['cantidad_disponible'];
        agregarLibro($titulo, $autor, $isbn, $anio_publicacion, $cantidad_disponible);
    } elseif (isset($_POST['delete'])) {
        // Eliminar libro
        $id = $_POST['id'];
        eliminarLibro($id);
    } elseif (isset($_POST['update'])) {
        // Actualizar libro
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $isbn = $_POST['isbn'];
        $anio_publicacion = $_POST['anio_publicacion'];
        $cantidad_disponible = $_POST['cantidad_disponible'];
        actualizarLibro($id, $titulo, $autor, $isbn, $anio_publicacion, $cantidad_disponible);
    } elseif (isset($_POST['buscar'])) {
        // Buscar libro
        $campo = $_POST['campo'];
        $valor = $_POST['valor'];
        $resultados = buscarLibro($campo, $valor);
    }
}

// Listar libros
$libros = listarLibros();
$usuarios = listarUsuarios();
$prestamos = listarPrestamosActivos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Biblioteca</title>
</head>
<body>
    <h1>Gestión de Biblioteca</h1>

    <h2>Añadir Libro</h2>
    <form method="POST">
        <input type="text" name="titulo" placeholder="Título" required>
        <input type="text" name="autor" placeholder="Autor" required>
        <input type="text" name="isbn" placeholder="ISBN" required>
        <input type="number" name="anio_publicacion" placeholder="Año de Publicación" required>
        <input type="number" name="cantidad_disponible" placeholder="Cantidad Disponible" required>
        <button type="submit" name="add">Añadir</button>
    </form>

    <h2>Buscar Libro</h2>
    <form method="POST">
        <input type="text" name="campo" placeholder="Buscar por título, autor o ISBN" required>
        <input type="text" name="valor" placeholder="Valor" required>
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <?php if (isset($resultados)): ?>
    <h2>Resultados de búsqueda:</h2>
    <?php if (count($resultados) > 0): ?>
        <ul>
            <?php foreach ($resultados as $libro): ?>
                <li><?php echo htmlspecialchars($libro['titulo']); ?> - <?php echo htmlspecialchars($libro['autor']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No se encontraron libros que coincidan con su búsqueda.</p>
    <?php endif; ?>
    <?php endif; ?>


    <h2>Lista de Libros</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>ISBN</th>
            <th>Año de Publicación</th>
            <th>Cantidad Disponible</th>
            <th>Acciones</th>
        </tr>
        <?php if (!empty($libros)): ?>
            <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?php echo $libro['id']; ?></td>
                    <td><?php echo $libro['titulo']; ?></td>
                    <td><?php echo $libro['autor']; ?></td>
                    <td><?php echo $libro['isbn']; ?></td>
                    <td><?php echo $libro['anio_publicacion']; ?></td>
                    <td><?php echo $libro['cantidad_disponible']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
                            <button type="submit" name="delete">Eliminar</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
                            <input type="text" name="titulo" value="<?php echo $libro['titulo']; ?>" required>
                            <input type="text" name="autor" value="<?php echo $libro['autor']; ?>" required>
                            <input type="text" name="isbn" value="<?php echo $libro['isbn']; ?>" required>
                            <input type="number" name="anio_publicacion" value="<?php echo $libro['anio_publicacion']; ?>" required>
                            <input type="number" name="cantidad_disponible" value="<?php echo $libro['cantidad_disponible']; ?>" required>
                            <button type="submit" name="update">Actualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No hay libros registrados.</td>
            </tr>
        <?php endif; ?>
    </table>

    <h2>Añadir Usuario</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required> <!-- Cambiado a 'contraseña' -->
        <button type="submit" name="add_user">Añadir</button>
    </form>

    <h2>Lista de Usuarios</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
        <?php if (!empty($usuarios)): ?>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                            <button type="submit" name="delete_user">Eliminar</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                            <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
                            <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>
                            <input type="password" name="contraseña" placeholder="Contraseña (opcional)"> <!-- Cambiado a 'contraseña' -->
                            <button type="submit" name="update_user">Actualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No hay usuarios registrados.</td>
            </tr>
        <?php endif; ?>
    </table>

    <h2>Registrar Préstamo</h2>
    <form method="POST">
        <select name="id_usuario" required>
            <option value="">Seleccionar Usuario</option>
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nombre']; ?></option>
            <?php endforeach; ?>
        </select>
        <select name="id_libro" required>
            <option value="">Seleccionar Libro</option>
            <?php foreach ($libros as $libro): ?>
                <option value="<?php echo $libro['id']; ?>"><?php echo $libro['titulo']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="add_prestamo">Registrar Préstamo</button>
    </form>

    <h2>Devolver Préstamo</h2>
    <form method="POST">
        <select name="id_usuario" required>
            <option value="">Seleccionar Usuario</option>
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nombre']; ?></option>
            <?php endforeach; ?>
        </select>
        <select name="id_libro" required>
            <option value="">Seleccionar Libro</option>
            <?php foreach ($libros as $libro): ?>
                <option value="<?php echo $libro['id']; ?>"><?php echo $libro['titulo']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="return_prestamo">Devolver Préstamo</button>
    </form>

    <h2>Lista de Préstamos Activos</h2>
    <table border="1">
        <tr>
            <th>ID Usuario</th>
            <th>ID Libro</th>
            <th>Acciones</th>
        </tr>
        <?php if (!empty($prestamos)): ?>
            <?php foreach ($prestamos as $prestamo): ?>
                <tr>
                    <td><?php echo $prestamo['id_usuario']; ?></td>
                    <td><?php echo $prestamo['id_libro']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_usuario" value="<?php echo $prestamo['id_usuario']; ?>">
                            <input type="hidden" name="id_libro" value="<?php echo $prestamo['id_libro']; ?>">
                            <button type="submit" name="return_prestamo">Devolver</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No hay préstamos activos.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

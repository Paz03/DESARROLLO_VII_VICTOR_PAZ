<?php
require_once 'validaciones.php';
require_once 'sanitizacion.php';

// Verificar el método de solicitud
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errores = [];
    $datos = [];

    // Procesar y validar cada campo
    $campos = ['nombre', 'email', 'sitio_web', 'genero', 'intereses', 'comentarios', 'fecha_nacimiento'];
    foreach ($campos as $campo) {
        if (isset($_POST[$campo])) {
            $valor = $_POST[$campo];
            $valorSanitizado = call_user_func("sanitizar" . ucfirst(str_replace('_', '', $campo)), $valor); // Aquí se ajusta el nombre de la función
            $datos[$campo] = $valorSanitizado;

            if (!call_user_func("validar" . ucfirst(str_replace('_', '', $campo)), $valorSanitizado)) {
                $errores[] = "El campo $campo no es válido.";
            }
        }
    }

    // Calcular edad a partir de la fecha de nacimiento
    if (isset($datos['fecha_nacimiento'])) {
        $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $datos['fecha_nacimiento']);
        if ($fechaNacimiento === false) {
            $errores[] = "La fecha de nacimiento no es válida.";
        } else {
            $hoy = new DateTime();
            $datos['edad'] = $hoy->diff($fechaNacimiento)->y;
        }
    }

    // Procesar la foto de perfil
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_NO_FILE) {
        if (!validarFotoPerfil($_FILES['foto_perfil'])) {
            $errores[] = "La foto de perfil no es válida.";
        } else {
            // Verificar si el archivo ya existe
            $nombreArchivo = basename($_FILES['foto_perfil']['name']);
            $rutaDestino = 'uploads/' . $nombreArchivo;

            if (file_exists($rutaDestino)) {
                $errores[] = "El archivo ya existe. Por favor, elige otro.";
            } else {
                // Mover el archivo a la carpeta uploads
                if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                    $datos['foto_perfil'] = $rutaDestino;
                } else {
                    $errores[] = "Hubo un error al subir la foto de perfil.";
                }
            }
        }
    }

    // Mostrar resultados o errores
    if (empty($errores)) {
        echo "<h2>Datos Recibidos:</h2>";
        echo "<table border='1'>";
        foreach ($datos as $campo => $valor) {
            echo "<tr>";
            echo "<th>" . ucfirst($campo) . "</th>";
            if ($campo === 'intereses') {
                echo "<td>" . implode(", ", $valor) . "</td>";
            } elseif ($campo === 'foto_perfil') {
                echo "<td><img src='$valor' width='100'></td>";
            } else {
                echo "<td>" . htmlspecialchars($valor) . "</td>"; // Sanitizar salida
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "<br><a href='formulario.html'>Volver al formulario</a>";
    } else {
        echo "<h2>Errores:</h2>";
        echo "<ul>";
        foreach ($errores as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>"; // Sanitizar salida
        }
        echo "</ul>";
        echo "<br><a href='formulario.html'>Volver al formulario</a>";
    }
} else {
    echo "Acceso no permitido.";
}
?>

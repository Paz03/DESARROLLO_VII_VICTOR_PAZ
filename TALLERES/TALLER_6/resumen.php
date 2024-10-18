<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Registros</title>
</head>
<body>
    <h2>Resumen de Registros</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha de Nacimiento</th>
                <th>Sitio Web</th>
                <th>Género</th>
                <th>Intereses</th>
                <th>Comentarios</th>
                <th>Foto de Perfil</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (file_exists('registros.json')) {
                $registros = json_decode(file_get_contents('registros.json'), true);
                foreach ($registros as $registro) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($registro['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($registro['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($registro['fecha_nacimiento']) . "</td>";
                    echo "<td>" . htmlspecialchars($registro['sitio_web']) . "</td>";
                    echo "<td>" . htmlspecialchars($registro['genero']) . "</td>";
                    echo "<td>" . implode(", ", array_map('htmlspecialchars', $registro['intereses'])) . "</td>";
                    echo "<td>" . htmlspecialchars($registro['comentarios']) . "</td>";
                    echo "<td><img src='uploads/" . htmlspecialchars($registro['foto_perfil']) . "' alt='Foto de Perfil' width='100'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No hay registros disponibles.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

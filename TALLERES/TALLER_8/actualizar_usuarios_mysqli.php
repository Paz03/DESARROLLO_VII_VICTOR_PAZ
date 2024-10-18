<?php
require_once "config_mysqli.php";

$nombre = "Juan3";
$email = "juan3@ejemplo.com";
$id = 2;

$sql = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";

if($stmt = mysqli_prepare($conn, $sql)){
    mysqli_stmt_bind_param($stmt, "ssi", $nombre, $email, $id);

    if(mysqli_stmt_execute($stmt)){
        echo "Registro actualizado correctamente.";
    } else{
        echo "ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else{
    echo "ERROR: No se pudo preparar la consulta. " . mysqli_error($conn);
}

mysqli_close($conn);
?>

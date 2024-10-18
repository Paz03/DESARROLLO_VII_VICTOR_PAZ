<?php
require_once "config_mysqli.php";

$id = 3;

$sql = "DELETE FROM usuarios WHERE id = ?";

if($stmt = mysqli_prepare($conn, $sql)){
    mysqli_stmt_bind_param($stmt, "i", $id);

    if(mysqli_stmt_execute($stmt)){
        echo "Registro eliminado correctamente.";
    } else{
        echo "ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else{
    echo "ERROR: No se pudo preparar la consulta. " . mysqli_error($conn);
}

mysqli_close($conn);
?>

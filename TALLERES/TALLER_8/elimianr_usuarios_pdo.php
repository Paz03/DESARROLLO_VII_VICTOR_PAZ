<?php
require_once "config_pdo.php";

$id = 2;

$sql = "DELETE FROM usuarios WHERE id = :id";

if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "Registro eliminado correctamente.";
    } else {
        echo "ERROR: No se pudo ejecutar la consulta. " . $stmt->errorInfo()[2];
    }
}

unset($stmt);
unset($pdo);
?>

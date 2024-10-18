<?php
require_once "config_pdo.php";

$nombre = "Luis";
$email = "luis@gmail.com";
$id = 2;

$sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";

if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "Registro actualizado correctamente.";
    } else {
        echo "ERROR: No se pudo ejecutar la consulta. " . $stmt->errorInfo()[2];
    }
}

unset($stmt);
unset($pdo);
?>

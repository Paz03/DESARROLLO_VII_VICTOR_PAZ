<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php"); 
    exit();
}

$profesor = $_SESSION["usuario"];
$usuarios = [
    "luis" => ["calificacion" => 80],
    "maria" => ["calificacion" => 20],
    "lucas" => ["calificacion" => 100]
];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Profesor</title>
</head>
<body>
    <a href="cerrar_sesion.php">Cerrar sesion</a>
    <br>
    <?php foreach ($usuarios as $usuario => $calificacion): ?>
            <?php echo "nombre:".htmlspecialchars($usuario); ?>
            <?php echo "    calificacion:". $calificacion["calificacion"]; ?></td>
            <br>
    <?php endforeach; ?>
</body>
</html>

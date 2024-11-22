<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit();
}

$usuario = $_SESSION["usuario"];
$calificacion = $_SESSION["calificacion"];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <a href="cerrar_sesion.php">Cerrar sesion</a>
        <p>Tu calificación es: <?php echo $calificacion; ?></p>

</body>
</html>

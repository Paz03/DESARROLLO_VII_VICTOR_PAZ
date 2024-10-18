
<?php
session_start();

$_SESSION['usuario'] = "Victor";
$_SESSION['rol'] = "admin";

echo "Sesión iniciada para " . $_SESSION['usuario'];
?>
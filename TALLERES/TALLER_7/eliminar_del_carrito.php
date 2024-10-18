<?php
include 'config_sesion.php';

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    if (isset($_SESSION['carrito'][$id])) {
        unset($_SESSION['carrito'][$id]);
    }

    // Redirigir a la página del carrito
    header("Location: ver_carrito.php");
    exit();
}
?>
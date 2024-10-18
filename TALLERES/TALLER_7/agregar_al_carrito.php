<?php
include 'config_sesion.php';

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    // Inicializar el carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Añadir producto al carrito
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]++;
    } else {
        $_SESSION['carrito'][$id] = 1;
    }

    // Redirigir a la página de productos
    header("Location: productos.php");
    exit();
}
?>
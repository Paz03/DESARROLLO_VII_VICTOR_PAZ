<?php

$paginaActual = 'inicio'; // Cambia esto según el archivo
require_once 'plantillas/funciones.php';
$tituloPagina = obtenerTituloPagina($paginaActual);
include 'plantillas/encabezado.php';

$libros = obtenerLibros();
?>

<h1>Listado de Libros</h1>

<?php
// Mostrar los detalles de cada libro
foreach ($libros as $libro) {
    echo mostrarDetallesLibro($libro);
}
?>

<?php
include 'plantillas/pie_pagina.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloPagina; ?></title>
    <link rel="stylesheet" type="text/css" href="../CATALOGO_LIBROS/CSS/estilo.css">

</head>
<body>
    <header>
        <h1><?php echo $tituloPagina; ?></h1>
        <?php echo generarMenu($paginaActual); ?>
    </header>
    <main>
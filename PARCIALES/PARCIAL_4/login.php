<?php
// login.php
// Incluir la clase de GoogleOAuth para manejar la autenticación de Google
require_once 'GoogleOAuth.php';

// Obtener la URL de autenticación desde la clase GoogleOAuth
$urlDeAutenticacion = GoogleOAuth::obtenerUrlDeAutenticacion();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login con Google</title>
    <style>
        /* Estilos para centrar el contenido en la pantalla */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Color de fondo */
        }
        .login-container {
            text-align: center;  /* Centrar el contenido dentro del contenedor */
            background-color: #fff;  /* Fondo blanco para el contenedor */
            padding: 40px;  /* Espaciado interior */
            border-radius: 8px;  /* Bordes redondeados */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);  /* Sombra del contenedor */
            width: 300px;  /* Ancho del contenedor */
        }
        h2 {
            color: #333;  /* Color del título */
            margin-bottom: 20px;  /* Espacio debajo del título */
        }
        a {
            text-decoration: none;  /* Quitar subrayado al enlace */
            color: #fff;  /* Color de texto blanco */
            background-color: #4285f4; /* Color de fondo de Google */
            padding: 10px 20px;  /* Espaciado del botón */
            border-radius: 4px;  /* Bordes redondeados para el botón */
            font-weight: bold;  /* Texto en negrita */
            transition: background-color 0.3s;  /* Transición suave para el cambio de color */
        }
        a:hover {
            background-color: #357ae8;  /* Cambiar color al pasar el ratón sobre el botón */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        <!-- Enlace para iniciar sesión con Google, redirige a la URL de autenticación de Google -->
        <a href="<?php echo $urlDeAutenticacion; ?>">Iniciar sesión con Google</a>
    </div>
</body>
</html>

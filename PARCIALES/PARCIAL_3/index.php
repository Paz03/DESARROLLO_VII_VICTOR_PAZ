<?php
session_start();

$usuarios = [
    "luis" => ["password" => "123456", "calificacion" => 80],
    "maria" => ["password" => "654321", "calificacion" => 20],
    "lucas" => ["password" => "112233", "calificacion" => 100]
];

$profesor = [
    "profesor" => ["password" => "profe"],
];

if (isset($_SESSION["usuario"])) {
    if ($_SESSION["usuario"] == "profesor") {
        header("Location: dashboard_profesor.php");
    } else {
        header("Location: dashboard.php");
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    if (isset($profesor[$usuario]) && $profesor[$usuario]["password"] === $contraseña) {
        $_SESSION["usuario"] = $usuario;
        header("Location: dashboard_profesor.php");
        exit();
    }

    if (isset($usuarios[$usuario]) && $usuarios[$usuario]["password"] === $contraseña) {
        $_SESSION["usuario"] = $usuario;
        $_SESSION["calificacion"] = $usuarios[$usuario]["calificacion"];
        header("Location: dashboard.php");
        exit();
    }

    $error = "Usuario o contraseña incorrectos.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required>
        <br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" id="contraseña" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>

<?php
include('includes/conexion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $stmt = $conexion->prepare("SELECT id, nombre_completo, usuario, contrasena, rol FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $usuarioBD = $resultado->fetch_assoc();

        if (password_verify($password, $usuarioBD['contrasena'])) {
            $_SESSION['usuario'] = $usuarioBD['usuario'];
            $_SESSION['rol'] = $usuarioBD['rol'];
            $_SESSION['usuario_id'] = $usuarioBD['id'];
            header('Location: panel.php');
            exit;
        } else {
            $error = "❌ Contraseña incorrecta.";
        }
    } else {
        $error = "❌ Usuario no encontrado.";
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login </title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="login-box">
        <div class="logo-titulo">REPARACIÓN DE CELULARES Y LAPTOPS (R S C)</div>
        <h2>Iniciar Sesión</h2>
        <form method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Entrar">
        </form>
    </div>

    <?php if (isset($error)) : ?>
        <div id="errorMsg" class="floating-error"><?php echo $error; ?></div>
        <script>
            const errorDiv = document.getElementById('errorMsg');
            errorDiv.classList.add('show');

            setTimeout(() => {
                errorDiv.classList.remove('show');
            }, 3000);
        </script>
    <?php endif; ?>
</body>
</html>





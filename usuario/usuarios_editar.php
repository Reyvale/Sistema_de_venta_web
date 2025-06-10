<?php
include '../includes/conexion.php';
session_start();

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: usuarios.php");
    exit;
}

$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../css/usuarios1.css">
</head>
<body>
<div class="container">
    <h2>Editar Usuario</h2>
    <form action="usuarios.php" method="POST" class="form-usuario">
        <input type="hidden" name="accion" value="editar">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        <input type="text" name="nombre_completo" placeholder="Nombre completo" value="<?= htmlspecialchars($usuario['nombre_completo']) ?>" required>
        <input type="text" name="usuario" placeholder="Usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>" required>
        <input type="password" name="contrasena" placeholder="Nueva contraseña (opcional)">
        <select name="rol" required>
            <option value="">Seleccione rol</option>
            <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
            <option value="vendedor" <?= $usuario['rol'] === 'vendedor' ? 'selected' : '' ?>>Vendedor</option>
        </select>
        <button type="submit">Guardar Cambios</button>
    </form>
    <br>
    <a href="usuarios.php" class="btn-volver">← Volver a Usuarios</a>
</div>
</body>
</html>

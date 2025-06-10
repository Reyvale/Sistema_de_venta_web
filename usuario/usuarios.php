<?php
include '../includes/conexion.php';
session_start();

// AGREGAR o EDITAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $nombre = $_POST['nombre_completo'];
    $usuario = $_POST['usuario'];
    $rol = $_POST['rol'];
    $id = $_POST['id'] ?? null;

    $contrasena = !empty($_POST['contrasena']) ? password_hash($_POST['contrasena'], PASSWORD_DEFAULT) : null;

    if ($_POST['accion'] === 'agregar') {
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_completo, usuario, contrasena, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $usuario, $contrasena, $rol);
        $stmt->execute();
    } elseif ($_POST['accion'] === 'editar' && $id) {
        if ($contrasena) {
            $stmt = $conexion->prepare("UPDATE usuarios SET nombre_completo=?, usuario=?, contrasena=?, rol=? WHERE id=?");
            $stmt->bind_param("ssssi", $nombre, $usuario, $contrasena, $rol, $id);
        } else {
            $stmt = $conexion->prepare("UPDATE usuarios SET nombre_completo=?, usuario=?, rol=? WHERE id=?");
            $stmt->bind_param("sssi", $nombre, $usuario, $rol, $id);
        }
        $stmt->execute();
    }

    header("Location: usuarios.php");
    exit;
}

// ELIMINAR
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: usuarios.php");
    exit;
}

// CONSULTA DE TODOS LOS USUARIOS
$usuarios = $conexion->query("SELECT * FROM usuarios ORDER BY id DESC");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../css/usuarios1.css">
</head>
<body>
    <div class="container">
        <h2>Gestión de Usuarios</h2>

        <!-- Botón de regreso al panel -->
        <a href="../panel.php" class="btn-regresar">⬅️ Regresar</a>

        <!-- Formulario de usuarios -->
        <form action="usuarios.php" method="POST" class="form-usuario">
            <input type="hidden" name="accion" value="agregar">
            <input type="text" name="nombre_completo" placeholder="Nombre completo" required>
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <select name="rol" required>
                <option value="">Seleccione rol</option>
                <option value="admin">Administrador</option>
                <option value="vendedor">Vendedor</option>
            </select>
            <button type="submit">Agregar Usuario</button>
        </form>

        <h3>Lista de Usuarios</h3>
        <table class="tabla-usuarios">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($u = mysqli_fetch_assoc($usuarios)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($u['nombre_completo']) ?></td>
                        <td><?= htmlspecialchars($u['usuario']) ?></td>
                        <td><?= htmlspecialchars($u['rol']) ?></td>
                        <td>
                            <a href="usuarios_editar.php?id=<?= $u['id'] ?>">✏️ Editar</a> | 
                            <a href="usuarios.php?eliminar=<?= $u['id'] ?>" onclick="return confirm('¿Eliminar este usuario?')">🗑️ Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
include '../includes/conexion.php';
$id = $_GET['id'];
$resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id");
$producto = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../css/productos.css">
</head>
<body>
<div class="main-content">
    <h2>✏️ Editar producto</h2>
    <a href="../productos/productos.php" class="btn-agregar">🚪 Regresar</a>
    <form action="actualizar_producto.php" method="post">
        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
        <input type="text" name="nombre" value="<?= $producto['nombre'] ?>" required>
        <textarea name="descripcion"><?= $producto['descripcion'] ?></textarea>
        <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required>
        <input type="number" name="stock" value="<?= $producto['stock'] ?>" required>
        <button type="submit">Actualizar</button>
    </form>
</div>
</body>
</html>

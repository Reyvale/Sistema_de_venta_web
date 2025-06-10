<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
    <link rel="stylesheet" href="../css/productos.css">
</head>
<body>
<div class="main-content">
    <h2>➕ Registrar nuevo producto</h2>
    <a href="../productos/productos.php" class="btn-agregar">🚪 Regresar</a>
    <form action="insertar_producto.php" method="post">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <textarea name="descripcion" placeholder="Descripción"></textarea>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required>
        <input type="number" name="stock" placeholder="Cantidad en stock" required>
        <button type="submit">Guardar</button>
    </form>
</div>
</body>
</html>

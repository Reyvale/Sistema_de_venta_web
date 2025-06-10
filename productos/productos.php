
<?php
// Conexión a la base de datos
include '../includes/conexion.php';
$consulta = "SELECT * FROM productos";
$resultado = mysqli_query($conexion, $consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="../css/productos.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
</head>
<body>

<div class="main-content">
    <h1>Gestión de Productos</h1>
    <a href="nuevo_producto.php" class="btn-agregar">➕ Agregar Producto</a>
     <a href="../panel.php" class="btn-agregar">🚪 Regresar</a>
     <!-- En un archivo como productos.php -->
<a href="importar_productos.php" class="btn-agregar">📥 Importar Productos</a>


    <table id="tabla-productos" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?= $fila['nombre'] ?></td>
                <td><?= $fila['descripcion'] ?></td>
                <td>$<?= number_format($fila['precio'], 2) ?></td>
                <td><?= $fila['stock'] ?></td>
                <td>
                    <a href="editar_producto.php?id=<?= $fila['id'] ?>">✏️</a>
                    <a href="eliminar_producto.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Eliminar este producto?')">🗑️</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Scripts de DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
$(document).ready(function() {
    $('#tabla-productos').DataTable({
        responsive: true,
        language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_",
            paginate: {
                first: "Primero", last: "Último",
                next: "➡", previous: "⬅"
            },
            zeroRecords: "No se encontraron productos"
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Lista_de_Productos'
            },
                    ]
    });
});
</script>

</body>
</html>

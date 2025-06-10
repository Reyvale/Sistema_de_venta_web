<?php
// Encabezados para forzar descarga como Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=inventario_" . date("Ymd") . ".xls");

// Conexión a la base de datos
include '../includes/conexion.php';

$resultado = mysqli_query($conexion, "SELECT nombre, stock, precio FROM productos");

// Inicio de tabla
echo "<table border='1'>";

// Título superior
echo "<tr>";
echo "<th colspan='3' style='font-size:20px; background-color:#dff0d8;'>INVENTARIO DE PRODUCTOS</th>";
echo "</tr>";

// Encabezados de columnas
echo "<tr style='background-color:#f2f2f2;'>
        <th>Nombre</th>
        <th>Stock</th>
        <th>Precio</th>
      </tr>";

// Filas de productos
while ($row = mysqli_fetch_assoc($resultado)) {
    echo "<tr>
            <td>{$row['nombre']}</td>
            <td>{$row['stock']}</td>
            <td>{$row['precio']}</td>
          </tr>";
}

echo "</table>";
?>

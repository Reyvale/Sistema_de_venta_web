<?php
include '../includes/conexion.php';

$resultado = mysqli_query($conexion, "SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>📊 Inventario</title>
    <link rel="stylesheet" href="../css/inventario.css">
</head>
<body>
    <div class="container">
        <h2>📦 Inventario de Productos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Actualizar</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($resultado)) {
                    $estado = $row['stock'] <= 5 ? "<span class='bajo'>Bajo</span>" : "<span class='ok'>Suficiente</span>";
                    echo "<tr>
                            <td>{$row['nombre']}</td>
                            <td>{$row['stock']}</td>
                            <td>$ {$row['precio']}</td>
                            <td>$estado</td>
                            <td>
                                <form action='actualizar_stock.php' method='POST'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <input type='number' name='cantidad' placeholder='Cantidad' required>
                                    <select name='tipo'>
                                        <option value='entrada'>Entrada</option>
                                        <option value='salida'>Salida</option>
                                    </select>
                                    <button type='submit'>Actualizar</button>
                                </form>
                            </td>
                        </tr>";
                } ?>
            </tbody>
        </table>
        <button onclick="window.print()" class="print-btn">🖨️ Imprimir Registros</button>
        <form action="exportar_excel.php" method="post" style="display:inline;">
    <button type="submit" class="excel-btn">📥 Exportar a Excel</button>
</form>

        <a href="../panel.php" class="btn-volver">🔙 Volver</a>
    </div>
</body>
</html>

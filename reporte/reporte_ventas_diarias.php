<?php
include '../includes/conexion.php';

// Establecer zona horaria y obtener fecha actual
date_default_timezone_set('America/Mexico_City');
$fecha_actual = date('Y-m-d');
$fechaHora = date('d/m/Y H:i:s');

// Consulta para ventas del día
$sql = "SELECT v.id, v.fecha, v.total, u.nombre_completo AS usuario
        FROM ventas v
        JOIN usuarios u ON v.usuario_id = u.id
        WHERE DATE(v.fecha) = '$fecha_actual'
        ORDER BY v.fecha DESC";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Reporte de Ventas Diarias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
        }
        .fecha {
            text-align: right;
            margin-bottom: 15px;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn {
            display: block;
            width: 160px;
            margin: 10px auto;
            padding: 10px 0;
            background-color:rgb(55, 61, 71);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 0 10px rgba(23, 177, 30, 0.6);
        }
        .btn:hover {
            background-color:rgb(28, 158, 46);
        }
        @media print {
            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>

<h2>Reporte de Ventas Diarias</h2>
<div class="fecha">Generado: <?= $fechaHora ?></div>

<table>
    <thead>
        <tr>
            <th>ID Venta</th>
            <th>Fecha y Hora</th>
            <th>Total ($)</th>
            <th>Usuario</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while ($venta = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?= $venta['id'] ?></td>
                    <td><?= date('d/m/Y H:i:s', strtotime($venta['fecha'])) ?></td>
                    <td><?= number_format($venta['total'], 2) ?></td>
                    <td><?= htmlspecialchars($venta['usuario']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align:center;">No hay ventas registradas hoy.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<button class="btn" onclick="window.print()">🖨️ Imprimir</button>
<a href="reportes.php" class="btn">🔙 Regresar</a>

</body>
</html>

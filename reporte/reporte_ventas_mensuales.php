<?php
include '../includes/conexion.php';

date_default_timezone_set('America/Mexico_City');

// Array con nombres de meses en español
$meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];

// Selección por defecto: mes actual y año actual
$mesSeleccionado = date('n');  // número del mes sin cero inicial
$anioSeleccionado = date('Y');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mesSeleccionado = intval($_POST['mes']);
    $anioSeleccionado = intval($_POST['anio']);
}

// Preparar consulta con parámetros
$sql = "SELECT v.id, v.fecha, v.total, u.nombre_completo AS usuario
        FROM ventas v
        INNER JOIN usuarios u ON v.usuario_id = u.id
        WHERE MONTH(v.fecha) = ? AND YEAR(v.fecha) = ?
        ORDER BY v.fecha ASC";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die('Error en la preparación de la consulta: ' . $conexion->error);
}

$stmt->bind_param('ii', $mesSeleccionado, $anioSeleccionado);

$stmt->execute();

$resultado = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Reporte de Ventas Mensuales</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        select, input[type="number"] {
            padding: 5px;
            font-size: 16px;
            margin: 0 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
    </style>
</head>
<body>

<h2>Reporte de Ventas Mensuales</h2>

<form method="POST" action="">
    <label for="mes">Mes:</label>
    <select name="mes" id="mes" required>
        <?php foreach ($meses as $num => $nombre): ?>
            <option value="<?= $num ?>" <?= ($num === $mesSeleccionado) ? 'selected' : '' ?>>
                <?= $nombre ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="anio">Año:</label>
    <input type="number" id="anio" name="anio" min="2000" max="<?= date('Y') ?>" value="<?= $anioSeleccionado ?>" required />

    <button type="submit" class="btn-imprimir">Filtrar</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID Venta</th>
            <th>Fecha</th>
            <th>Total ($)</th>
            <th>Usuario</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($venta = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($venta['id']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($venta['fecha'])) ?></td>
                    <td><?= number_format($venta['total'], 2) ?></td>
                    <td><?= htmlspecialchars($venta['usuario']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="text-align:center;">No se encontraron ventas para este mes.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<button class="btn" onclick="window.print()">🖨️ Imprimir</button>
<a href="reportes.php" class="btn">🔙 Regresar</a>

</body>
</html>
<?php
$stmt->close();
$conexion->close();
?>

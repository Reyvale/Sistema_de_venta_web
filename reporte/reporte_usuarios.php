<?php
include '../includes/conexion.php';

// Obtener usuarios
$sql = "SELECT id, nombre_completo, usuario, rol FROM usuarios ORDER BY nombre_completo ASC";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error al obtener los usuarios: " . mysqli_error($conexion));
}

// Fecha actual
date_default_timezone_set('America/Mexico_City');
$fechaHora = date('d/m/Y H:i:s');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Usuarios</title>
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
        .btn-imprimir, .btn-regresar {
            display: block;
            width: 150px;
            margin: 10px auto;
            padding: 10px 0;
            background-color: rgb(53, 59, 54);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 0 10px rgb(22, 150, 39);
            transition: background-color 0.3s ease;
            text-align: center;
            text-decoration: none;
        }
        .btn-imprimir:hover, .btn-regresar:hover {
            background-color: rgb(22, 150, 39);
        }
        @media print {
            .btn-imprimir, .btn-regresar {
                display: none;
            }
        }
    </style>
</head>
<body>

<h2>Reporte de Usuarios</h2>
<div class="fecha">Fecha de generación: <?= $fechaHora ?></div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Completo</th>
            <th>Usuario</th>
            <th>Rol</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($usuario = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?= htmlspecialchars($usuario['id']) ?></td>
            <td><?= htmlspecialchars($usuario['nombre_completo']) ?></td>
            <td><?= htmlspecialchars($usuario['usuario']) ?></td>
            <td><?= htmlspecialchars($usuario['rol']) ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<button class="btn-imprimir" onclick="window.print()">🖨️ Imprimir Reporte</button>
<a href="reportes.php" class="btn-regresar">🔙 Regresar</a>

</body>
</html>

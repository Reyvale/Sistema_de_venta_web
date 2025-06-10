<?php
include '../includes/conexion.php';

// Obtener productos
$sql = "SELECT id, nombre, descripcion, precio, stock FROM productos ORDER BY nombre ASC";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta de productos: " . mysqli_error($conexion));
}

// Fecha actual
date_default_timezone_set('America/Mexico_City');
$fechaHora = date('d/m/Y H:i:s');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Reporte de Productos</title>
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
        .btn-imprimir {
            display: block;
            width: 150px;
            margin: 0 auto;
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
        .btn-imprimir:hover {
            background-color:rgb(22, 150, 39);
        }

      @media print {
    .acciones-no-imprimir {
        display: none !important;
    }
}



        .btn-regresar {
            display: block;
            width: 150px;
            margin: 0 auto;
            padding: 10px 0;
            background-color:rgb(53, 59, 54);
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
        .btn-regresar:hover {
            background-color:rgb(22, 150, 39);
        }
        
    </style>
</head>
<body>

<h2>Reporte de Productos</h2>
<div class="fecha">Fecha de generación: <?= $fechaHora ?></div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio ($)</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($producto = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?= htmlspecialchars($producto['id']) ?></td>
                <td><?= htmlspecialchars($producto['nombre']) ?></td>
                <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                <td><?= number_format($producto['precio'], 2) ?></td>
                <td><?= htmlspecialchars($producto['stock']) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<!-- Botones en un contenedor separado -->
<div class="acciones-no-imprimir">
    <a href="reportes.php" class="btn-regresar">🔙 Regresar</a>
    <br>
    <button class="btn-imprimir" onclick="window.print()">🖨️ Imprimir Reporte</button>
</div>



 

</body>
</html>
